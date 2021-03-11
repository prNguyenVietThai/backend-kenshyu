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

    public function addPostTag(int $postId, int $tagId){
        $query = "INSERT INTO post_tag(post_id, tag_id) VALUE ($postId, $tagId)";
        $conn = $this->model->query($query);
        if(!$conn){
            return false;
        }
        return true;
    }

    public function deletePostTag(int $postId, int $tagId){
        $query = "DELETE FROM post_tag WHERE post_id=$postId AND tag_id=$tagId";
        $conn = $this->model->query($query);
        if(!$conn){
            return false;
        }
        return true;
    }

    public function create($post=[]){
        $title = $post['title'];
        $content = $post['content'];
        $user_id = $post['user_id'];

        $query = "INSERT INTO posts(title, content, user_id) value(:title, :content, :user_id);";
        $conn = $this->model->pdo;
        $set = $conn->prepare($query);
        $set->bindParam(':title', $title, PDO::PARAM_STR);
        $set->bindParam(':content', $content, PDO::PARAM_STR);
        $set->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $set->execute();
        $postId = $conn->lastInsertId();
        $post = $this->model->findById($postId);

        return $post;
    }

    public function getByUserId($userId){
        $query = "SELECT * FROM posts WHERE user_id=$userId";
        $cmd = $this->model->query($query);
        if(!$cmd) {
            return false;
        }
        return $cmd->fetchAll();
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
            WHERE posts.id = $postId
        ";
        if($edit){
            $query = $query." AND posts.user_id = $userId";
        }
        $post = $this->model->query($query);
        if(!$post) {
            return false;
        }
        return $post->fetch();
    }

    public function update(int $postId, array $post=[]){
        $title = $post['title'];
        $content = $post['content'];
        $user_id = $post['user_id'];
        $tags = $post['tags']; // input array tags

        $tagService = new TagServices();
        $qtags = $tagService->getByPostId($postId);
        $qtags = array_map(function ($t){
            return $t['id'];
        }, $qtags); // update array tags

        $addTags = array_diff($tags, $qtags);
        foreach ($addTags as $t){
            $this->addPostTag($postId, $t);
        }

        $deleteTags = array_diff($qtags, $tags);
        foreach ($deleteTags as $t){
            $this->deletePostTag($postId, $t);
        }

        $query = "
            UPDATE posts
            SET title = '$title', content = '$content'
            WHERE id = $postId AND user_id = $user_id;
        ";
        $data = $this->model->query($query);

        if(!$data) {
            return false;
        }
        return $data;
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
        $query = "DELETE FROM posts WHERE id='$id'";
        $comd = $this->model->query($query);

        if(!$comd){
            return false;
        }
        return true;
    }
}