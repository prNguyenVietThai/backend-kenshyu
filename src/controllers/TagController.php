<?php

class TagController extends Controller {
    public $model, $pdo;
    public function __construct()
    {
        $this->model = $this->model("Tag");
        $this->pdo = $this->model->db->pdo;
    }

    public function index(){
        $db = $this->model->find();
        var_dump($db);
    }

    public function store(){
        if($_SESSION['id']){
            $title = $_POST['title'];
            $description = $_POST['description'];
            if(!$title){
                return $this->response(400, [
                    "ok" => false,
                    "message" => "Tag title not null"
                ]);
            }

            $query = "INSERT INTO tags(title, description) value(:title, :description);";
            $conn = $this->pdo;
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $set = $conn->prepare($query);
            $set->bindParam(':title', $title, PDO::PARAM_STR);
            $set->bindParam(':description', $description, PDO::PARAM_STR);
            $set->execute();
            $tagId = $conn->lastInsertId();
            $tag = $this->model("Tag")->findOne("id='$tagId'");

            return $this->response(200, [
                "ok" => true,
                "message" => "create tag successfully",
                "tag" => $tag
            ]);
        } else {
            return $this->response(200, [
                "ok" => false,
                "message" => "Unauthenticated"
            ]);
        }
    }
}