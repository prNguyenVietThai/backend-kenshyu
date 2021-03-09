<?php
class PostController extends Controller {
    public function __construct() {
        $this->model = $this->model("Post");
    }

    public function index()
    {
        $data = $this->model("Post")->find();
        var_dump($data);
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
                                echo "tao thumbnail";
                                $imageModel = $this->model("Image");
                                $iconn = $imageModel->db->dbHandler;
                                $iconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $image = $iconn->query("
                                    INSERT INTO images (url, post_id)
                                    VALUES ('$dest_path', $postId);
                                ");
                                $imageId = $iconn->lastInsertId();
                                echo $imageId;
                                $update = $this->model("Post")->query("
                                    UPDATE posts
                                    SET thumbnail = $imageId
                                    WHERE id = $postId
                                ");
                                var_dump($update);
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

    private function getPostInfo($id)
    {
        $postId = $id;
        $post = $this->model("Post")->query("
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
                WHERE posts.id = $postId;
            ")->fetch();
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
        $data = $this->getPostInfo($id);
        $this->view("post-edit", $data);
    }

    public function update($id){
        $error = '';
        $title = $_POST['title'];
        $content = $_POST['content'];

        if(!$title || !$content){
            $error = 'Title or content not null';
        }
        if(!$error){
            $data = $this->model("Post")->query("
                UPDATE posts
                SET title = '$title', content = '$content'
                WHERE id = $id;
            ");
            if(!$data){
                $error = "Edit post faile";
            }
        }

        $post = $this->getPostInfo($id);
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
        $delete = $this->model("Post")->query("
            DELETE FROM posts WHERE id='$id';
        ");
        if(!$delete) {
            $this->response(400, [
                "ok" => false,
                "message" => "delete faile"
            ]);
        }else{
            $this->response(200, [
                "ok" => true,
                "message" => "delete success"
            ]);
        }
    }
}