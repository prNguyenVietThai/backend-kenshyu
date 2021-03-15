<?php
include_once __DIR__."/../services/TagServices.php";
include_once __DIR__."/../services/PostServices.php";
include_once __DIR__."/../services/ImageServices.php";

class PostController extends Controller {
    public function __construct() {
        $this->model = $this->model("Post");
    }

    public function index()
    {
        $data = $this->model("Post")->find();
    }

    public function create()
    {
        $tagServices = new TagServices();
        $tags = $tagServices->getAll();
        $this->view("post-create", [
            "tags" => $tags
        ]);
    }

    public function store()
    {
        $token = $_POST['token'];
        if(!CSRF::verify($token)){
            return $this->view("post-create", [
                "ok" => false,
                "message" => "csrf"
            ]);
        }

        $post = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'user_id' => $_POST['user_id'],
            'tags' => $_POST['tags'],
            'images' => $_FILES['images']
        ];

        $postService = new PostServices();
        $set = $postService->store($post);

        if($set){
            return $this->view("post-create", [
                "ok" => true,
                "message" => 'create post successfully'
            ]);
        }else{
            return $this->view("post-create", [
                "ok" => false,
                "message" => "create post faile"
            ]);
        }
    }

    public function show($id)
    {
        $postService = new PostServices();
        $post = $postService->getById($id);
        $tagService = new TagServices();
        $tags = $tagService->getByPostId($id);
        $imageService = new ImageServices();
        $images = $imageService->getByPostId($id);
        $this->view("post-show", [
            "post" => $post,
            "images" => $images,
            "tags" => $tags
        ]);
    }

    public function edit($id)
    {
        $postService = new PostServices();
        $post = $postService->getById($id, true);
        $tagService = new TagServices();
        $tags = $tagService->getAll();
        $tagsOfPost = $tagService->getByPostId($id);
        $imageService = new ImageServices();
        $images = $imageService->getByPostId($id);
        $this->view("post-edit", [
            "post" => $post,
            "images" => $images,
            "tags" => $tags,
            "tagsOfPost" => $tagsOfPost
        ]);
    }

    public function update($id){
        $postService = new PostServices();
        $tagService = new TagServices();
        $imageService = new ImageServices();
        $error = '';

        $postId = (int)$id;
        $userId = (int)$_SESSION['id'];
        if(!$postId || !$userId){
            $error = "Information invalid";
        }

        $token = $_POST['token'];
        if(!CSRF::verify($token)){
            $error = "csrf";
        }

        $ptitle = (string)$_POST['title'];
        $pcontent = (string)$_POST['content'];
        $ptags = (array)$_POST['tags'];

        if(!$ptitle || !$pcontent){
            $error = 'Title or content not null';
        }
        if(!$error){
            $data = $postService->update($postId, [
                "title" => $ptitle,
                "content" => $pcontent,
                "tags" => $ptags,
                "user_id" => $userId
            ]);
            if(!$data){
                $error = "Edit post faile";
            }
        }

        $post = $postService->getById($id);
        $tags = $tagService->getAll();
        $tagsOfPost = $tagService->getByPostId($id);
        $images = $imageService->getByPostId($id);

        if($error) {
            return $this->view("post-edit", [
                "ok" => false,
                "message" => $error,
                "post" => $post,
                "images" => $images,
                "tags" => $tags,
                "tagsOfPost" => $tagsOfPost
            ]);
        }else{
            return $this->view("post-edit", [
                "ok" => true,
                "message" => "update post successfully",
                "post" => $post,
                "images" => $images,
                "tags" => $tags,
                "tagsOfPost" => $tagsOfPost
            ]);
        }
    }

    public function delete($id)
    {
        $postService = new PostServices();
        $error = '';
        $token = $_POST['token'];
        if(!CSRF::verify($token)){
            $error = "csrf";
        }

        $user_id = $_SESSION['id'];
        if(!$user_id) {
            $error = "Unauthenticated";
            return $this->response(400, [
                "ok" => false,
                "message" => $error
            ]);
        }
        $delete = $postService->delete($id, $user_id);
        if(!$delete) {
            $error = "delete post faile";
            return $this->response(400, [
                "ok" => false,
                "message" => $error
            ]);
        }else{
            return $this->response(200, [
                "ok" => true,
                "message" => "delete success"
            ]);
        }
    }
}