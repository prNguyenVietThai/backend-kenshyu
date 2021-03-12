<?php
    class TagServices extends Services {
        public function __construct(){
            $this->model = $this->model("Tag");
        }

        public function getAll(){
            $query = "SELECT * FROM tags";
            $conn = $this->model->pdo;
            $set = $conn->prepare($query);
            $set->execute();
            if(!$set){
                return false;
            }
            return $set->fetchAll();
        }

        public function addPostTag(int $postId, int $tagId){
            $query = "INSERT INTO post_tag(post_id, tag_id) VALUE (:post_id, :tag_id)";
            $conn = $this->model->pdo;
            $set = $conn->prepare($query);
            $set->bindParam(':post_id', $postId, PDO::PARAM_INT);
            $set->bindParam(':tag_id', $tagId, PDO::PARAM_INT);
            $set->execute();
            if(!$set){
                return false;
            }
            return true;
        }

        public function create($tag = []){
            $title = $tag['title'];
            $description = $tag['description'];

            $query = "INSERT INTO tags(title, description) value(:title, :description);";
            $conn = $this->model->pdo;
            $set = $conn->prepare($query);
            $set->bindParam(':title', $title, PDO::PARAM_STR);
            $set->bindParam(':description', $description, PDO::PARAM_STR);
            $set->execute();
            $tagId = $conn->lastInsertId();
            $tag = $this->model->findById($tagId);

            return $tag;
        }

        public function getByPostId(int $postId){
            $query = "
                SELECT tags.id as id, tags.title as title, tags.description as description 
                FROM post_tag
                LEFT OUTER JOIN tags
                ON tags.id = post_tag.tag_id
                LEFT OUTER JOIN posts
                ON posts.id = post_tag.post_id
                WHERE post_tag.post_id = :postId;
            ";
            $conn = $this->model->pdo;
            $set = $conn->prepare($query);
            $set->bindParam(':postId', $postId, PDO::PARAM_INT);
            $set->execute();
            if(!$set){
                return false;
            }
            return $set->fetchAll();
        }
    }