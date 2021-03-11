<?php
include_once "TagServices.php";

class PostServices extends Services {
    public function __construct(){
        $this->model = $this->model("Post");
    }

    public function getAll(){
        $data = $this->model->find();
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

    public function update(int $postId, $post=[]){
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

    public function delete($id, $userId){
        $query = "DELETE FROM posts WHERE id='$id' AND user_id = $userId";
        $comd = $this->model->query($query);

        if(!$comd){
            return false;
        }
        return true;
    }
}