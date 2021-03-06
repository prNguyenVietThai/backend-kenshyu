<?php
include_once __DIR__."/../services/TagServices.php";

class TagController extends Controller {

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

            //create new tag
            $tagService = new TagServices();
            $tag = $tagService->create([
                "title" => $title,
                "description" => $description
            ]);

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