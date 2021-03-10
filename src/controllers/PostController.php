<?php
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
        $this->view("post-create");
    }

    public function store()
    {
        $error = "";
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = $_POST['user_id'];

        if(!$title || !$content || !$user_id){
            $error = 'information invalid';
        }

        if(!$error){
            $postModel = $this->model("Post");
            $conn = $postModel->db->dbHandler;
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $post = $conn->query("
                    INSERT INTO posts (title, content, user_id)
                    VALUES ('$title', '$content', '$user_id');
                ");
            $postId = $conn->lastInsertId();
            if(!$post){
                $error = 'cannot create post, try again later';
            }else{
                if($_FILES['images']['name'][0]) {
                    $fileExtensions = ["jpeg", "jpg", "png"];

                    for($i=0; $i < count($_FILES['images']['name']); $i++){
                        $fileTmpPath = $_FILES['images']['tmp_name'][$i];
                        $fileName = $_FILES['images']['name'][$i];
                        $fileNameCmps = explode(".", $fileName);
                        $fileExtension = strtolower(end($fileNameCmps));

                        $uploadFileDir = '/public/assets/';
                        $hashFileName = md5(time() . $fileName);
                        $dest_path = $uploadFileDir . $hashFileName . "." . $fileExtension;

                        if(in_array($fileExtension, $fileExtensions)){
                            move_uploaded_file($fileTmpPath, ".".$dest_path);
                            if($i == 0){
                                $imageModel = $this->model("Image");
                                $iconn = $imageModel->db->dbHandler;
                                $iconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $image = $iconn->query("
                                    INSERT INTO images (url, post_id)
                                    VALUES ('$dest_path', $postId);
                                ");
                                $imageId = $iconn->lastInsertId();
                                $update = $this->model("Post")->query("
                                    UPDATE posts
                                    SET thumbnail = $imageId
                                    WHERE id = $postId
                                ");
                            }else{
                                $this->model("Image")->query("
                                    INSERT INTO images (url, post_id)
                                    VALUES ('$dest_path', $postId);
                                ");
                            }
                        }
                    }
                }
            }
        }

        if(!$error){
            return $this->view("post-create", [
                "ok" => true,
                "message" => 'create post successfully'
            ]);
        }else{
            return $this->view("post-create", [
                "ok" => false,
                "message" => $error
            ]);
        }
    }

    private function getPostInfo($id, $edit=false)
    {
        $postId = $id;
        $userId = $_SESSION['id'];
        if(!$userId){
            return [
                "ok" => false,
                "message" => "Unauthenticated"
            ];
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

        $post = $this->model("Post")->query($query)->fetch();
        if(!$post){
            return [
                "ok" => false,
                "message" => "Permission denied"
            ];
        }
        $images = $this->model("Image")->query("SELECT * FROM images WHERE post_id = '$postId';")->fetchAll();

        return [
            "post" => $post,
            "images" => $images
        ];
    }

    public function show($id)
    {
        $data = $this->getPostInfo($id);
        $this->view("post-show", $data);
    }

    public function edit($id)
    {
        $data = $this->getPostInfo($id, true);
        $this->view("post-edit", $data);
    }

    public function update($id){
        $error = '';

        $postId = (int)$id;
        $userId = (int)$_SESSION['id'];
        if(!$postId || !$userId){
            $error = "Information invalid";
        }

        $title = (string)$_POST['title'];
        $content = (string)$_POST['content'];

        if(!$title || !$content){
            $error = 'Title or content not null';
        }
        if(!$error){
            $data = $this->model("Post")->query("
                UPDATE posts
                SET title = '$title', content = '$content'
                WHERE id = $postId AND user_id = $userId;
            ");
            if(!$data){
                $error = "Edit post faile";
            }
        }

        $post = $this->getPostInfo($postId);
        if($error) {
            return $this->view("post-edit", [
                "ok" => false,
                "message" => $error,
                "post" => $post["post"],
                "images" => $post["images"]
            ]);
        }else{
            return $this->view("post-edit", [
                "ok" => true,
                "message" => "update post successfully",
                "post" => $post["post"],
                "images" => $post["images"]
            ]);
        }
    }

    public function delete($id)
    {
        $error = '';
        $user_id = $_SESSION['id'];
        if(!$user_id) {
            $error = "Unauthenticated";
            return $this->response(400, [
                "ok" => false,
                "message" => $error
            ]);
        }
        $delete = $this->model("Post")->query("DELETE FROM posts WHERE id='$id' AND user_id = $user_id;");
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