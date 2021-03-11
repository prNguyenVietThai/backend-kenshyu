<?php
    class TagServices extends Services {
        public function __construct(){
            $this->model = $this->model("Tag");
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
                WHERE post_tag.post_id = $postId;
            ";
            $comd = $this->model->query($query);
            if(!$comd){
                return false;
            }
            $tags = $comd->fetchAll();
            return $tags;
        }
    }