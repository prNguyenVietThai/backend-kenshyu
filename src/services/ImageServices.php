<?php
class ImageServices extends Services {
    public function __construct(){
        $this->model = $this->model("Image");
    }

    public function getByPostId(int $postId){
        $images = $this->model->query("SELECT * FROM images WHERE post_id = '$postId';")->fetchAll();

        return $images;
    }
}