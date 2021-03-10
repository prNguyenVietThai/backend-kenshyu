<?php
    class Tag extends Model {
        public function create($tag = [])
        {
            $title = $tag['title'];
            $description = $tag['description'] ? $tag['description'] : "";

            if(!$title || !$description) {
                return false;
            }

            $query = "INSERT INTO tags (title, description) VALUES (:title, :description)";
            $conn = $this->db->prepare($query);
            $conn->bindParam(':title', $title, PDO::PARAM_STR);
            $conn->bindParam(':description', $description, PDO::PARAM_STR);

            return $conn->execute();
        }
    }