<?php
include_once "TagServices.php";

class PostServices extends Services {
    public function __construct(){
        $this->model = $this->model("Post");
    }

    public function getAll(){
        $data = $this->model->query("
                SELECT 
                    posts.id as id,
                    posts.title as title,
                    posts.content as content,
                    images.url as thumbnail,
                    users.id as user_id,
                    users.name as user_name,
                    users.email as user_email,
                    posts.created_at as created_at
                FROM posts
                LEFT OUTER JOIN users
                ON posts.user_id = users.id
                LEFT OUTER JOIN images
                ON posts.thumbnail = images.id
                ORDER BY posts.created_at DESC;
            ")->fetchAll();
        return $data;
    }

    public function getByUserId($userId){
        $query = "SELECT * FROM posts WHERE user_id=:userId";
        $conn = $this->model->pdo;
        $set = $conn->prepare($query);
        $set->bindParam(':userId', $userId, PDO::PARAM_INT);
        $set->execute();
        if(!$set) {
            return false;
        }
        return $set->fetchAll();
    }

    public function getById(int $id, $edit=false){
        $postId = $id;
        $userId = $_SESSION['id'];
        if(!$userId){
            return false;
        }
        $query = "
            SELECT 
                posts.id as id, 
                title, 
                content, 
                thumbnail, 
                user_id, 
                users.name as user_name, 
                users.email as user_email,
                posts.created_at as created_at
            FROM posts
            LEFT OUTER JOIN users
            ON posts.user_id = users.id
            WHERE posts.id = :postId
        ";
        if($edit){
            $query = $query." AND posts.user_id = :userId";
        }

        $conn = $this->model->pdo;
        $set = $conn->prepare($query);

        $set->bindParam(':postId', $postId, PDO::PARAM_INT);
        if($edit){
            $set->bindParam(':userId', $userId, PDO::PARAM_INT);
        }
        $set->execute();

        if(!$set) {
            return false;
        }
        return $set->fetch();
    }

    public function update(int $postId, array $post=[]){
        // Init transaction
        $conn = $this->model->pdo;
        $conn->beginTransaction();
        try {
            $title = $post['title'];
            $content = $post['content'];
            $user_id = $post['user_id'];
            $tags = $post['tags']; // input array tags

            $tagService = new TagServices();
            $qtags = $tagService->getByPostId($postId);
            $qtags = array_map(function ($t){
                return $t['id'];
            }, $qtags);

            // Add post tag
            $queryPostTag = "INSERT INTO post_tag(post_id, tag_id) VALUE (:postId, :tagId)";
            $addTags = array_diff($tags, $qtags);
            foreach ($addTags as $t){
                $set = $conn->prepare($queryPostTag);
                $set->bindParam(':postId', $postId, PDO::PARAM_INT);
                $set->bindParam(':tagId', $t, PDO::PARAM_INT);
                if(!$set->execute()){
                    throw new Exception("Add post tag faile");
                }
            }

            // Delete post tag
            $queryPostTagDelete = "DELETE FROM post_tag WHERE post_id=:postId AND tag_id=:tagId";
            $deleteTags = array_diff($qtags, $tags);
            foreach ($deleteTags as $t){
                $set = $conn->prepare($queryPostTagDelete);
                $set->bindParam(':postId', $postId, PDO::PARAM_INT);
                $set->bindParam(':tagId', $t, PDO::PARAM_INT);
                if(!$set->execute()){
                    throw new Exception("Delete post tag faile");
                }
            }

            $query = "
                UPDATE posts
                SET title = :title, content = :content
                WHERE id = :postId AND user_id = :userId;
            ";
            $set = $conn->prepare($query);
            $set->bindParam(':title', $title, PDO::PARAM_STR);
            $set->bindParam(':content', $content, PDO::PARAM_STR);
            $set->bindParam(':postId', $postId, PDO::PARAM_INT);
            $set->bindParam(':userId', $user_id, PDO::PARAM_INT);
            if(!$set->execute()){
                throw new Exception("Update post faile");
            }

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }

    public function updateThumbnail($postId, $imageId){
        $query = "UPDATE posts SET thumbnail = :imageId WHERE id = :postId";
        $conn = $this->model->pdo;
        $set = $conn->prepare($query);
        $set->bindParam(':postId', $postId, PDO::PARAM_INT);
        $set->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $d = $set->execute();
        if(!$d){
            return false;
        }
        return true;
    }

    public function delete(int $id, int $userId){
        $conn = $this->model->pdo;
        $conn->beginTransaction();
        try {
            $posts = $this->getByUserId($userId);
            if(!is_array($posts)){
                return false;
            }
            $posts = array_map(function($p){
                return $p['id'];
            }, $posts);
            if(!is_numeric(array_search($id, $posts))){
                return false;
            }

            $query = "DELETE FROM posts WHERE id=:id";
            $set = $conn->prepare($query);
            $set->bindParam(':id', $id, PDO::PARAM_INT);
            if(!$set->execute()){
                throw new Exception("Delete post faile");
            }

            $conn->commit();
            return true;
        }catch (Exception $e){
            $conn->rollBack();
            return false;
        }
    }

    public function store(array $post=[]){
        $title = $post['title'];
        $content = $post['content'];
        $user_id = $post['user_id'];
        $tags = $post['tags'];
        $images = $post['images'];

        $query = "INSERT INTO posts(title, content, user_id) value(:title, :content, :user_id);";
        $queryPostTag = "INSERT INTO post_tag(post_id, tag_id) VALUE (:post_id, :tag_id)";
        $queryImage = "INSERT INTO images (url, post_id) VALUES (:url, :post_id);";
        $queryThumbnail = "UPDATE posts SET thumbnail = :imageId WHERE id = :postId";

        $conn = $this->model->pdo;
        $conn->beginTransaction();
        try {
            // Create new post
            $conn = $this->model->pdo;
            $set = $conn->prepare($query);
            $set->bindParam(':title', $title, PDO::PARAM_STR);
            $set->bindParam(':content', $content, PDO::PARAM_STR);
            $set->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $setPost = $set->execute();
            if(!$setPost) {
                throw new Exception("Set post faile");
            }
            $postId = $conn->lastInsertId();

            // Add post - tag
            if(is_array($tags)){
                foreach ($tags as $tag){
                    $set = $conn->prepare($queryPostTag);
                    $set->bindParam(':post_id', $postId, PDO::PARAM_INT);
                    $set->bindParam(':tag_id', $tag, PDO::PARAM_INT);
                    $setTag = $set->execute();
                    if(!$setTag) {
                        throw new Exception("Set tag faile");
                    }
                }
            }

            // Add images
            if($images['name'][0]) {
                $fileExtensions = ["jpeg", "jpg", "png"];
                $uploadFileDir = '/public/assets/';

                for($i=0; $i < count($images['name']); $i++){
                    $fileTmpPath = $images['tmp_name'][$i];
                    $fileName = $images['name'][$i];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));

                    $hashFileName = md5(time() . $fileName);
                    $dest_path = $uploadFileDir . $hashFileName . "." . $fileExtension;

                    if(in_array($fileExtension, $fileExtensions)){
                        if(!move_uploaded_file($fileTmpPath, ".".$dest_path)){
                            throw new Exception("Store image file faile");
                        }

                        $set = $conn->prepare($queryImage);
                        $set->bindParam(':url', $dest_path, PDO::PARAM_STR);
                        $set->bindParam(':post_id', $postId, PDO::PARAM_INT);
                        $setImage = $set->execute();
                        if(!$setImage) {
                            throw new Exception("Set image faile");
                        }
                        $imageId = $conn->lastInsertId();

                        if($i == 0){
                            $set = $conn->prepare($queryThumbnail);
                            $set->bindParam(':postId', $postId, PDO::PARAM_INT);
                            $set->bindParam(':imageId', $imageId, PDO::PARAM_INT);
                            $setPostImage = $set->execute();
                            if(!$setPostImage) {
                                throw new Exception("Set post image faile");
                            }
                        }
                    }
                }
            }

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollback();
            return false;
        }
    }
}