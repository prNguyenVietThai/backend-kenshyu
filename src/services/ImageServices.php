<?php
class ImageServices extends Services {
    public function __construct(){
        $this->model = $this->model("Image");
    }

    public function getById(int $id){
        $image = $this->model->findById($id);

        return $image;
    }

    public function getByPostId(int $postId){
        $query = "SELECT * FROM images WHERE post_id = :post_id;";
        $conn = $this->model->pdo;
        $set = $conn->prepare($query);
        $set->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $set->execute();

        if(!$set){
            return false;
        }
        return $set->fetchAll();
    }

    public function create(array $image=[]){
        $url = (string)$image['url'];
        $post_id = (int)$image['post_id'];

        $query = "INSERT INTO images (url, post_id) VALUES (:url, :post_id);";

        $conn = $this->model->pdo;
        $set = $conn->prepare($query);
        $set->bindParam(':url', $url, PDO::PARAM_STR);
        $set->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $set->execute();
        $imageId = $conn->lastInsertId();

        return $this->getById($imageId);
    }
}