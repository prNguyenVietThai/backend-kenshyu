<?php
class AuthController extends Controller {
    public function index() {
        $data = [];
        if (isset($_SESSION) && $_SESSION['id'] && $_SESSION['email'] && $_SESSION['name']){
            $data = [
                'user' => [
                    'id' => $_SESSION['id'],
                    'name' => $_SESSION['name'],
                    'email' => $_SESSION['email']
                ]
            ];
        }

        $posts = $this->model("Post")->query("
                SELECT 
                    posts.id as id,
                    posts.title as title,
                    posts.content as content,
                    images.url as thumbnail,
                    users.id as user_id,
                    users.name as user_name,
                    users.email as user_email,
                    posts.created_at as created_at
                FROM posts
                LEFT OUTER JOIN users
                ON posts.user_id = users.id
                LEFT OUTER JOIN images
                ON posts.thumbnail = images.id
                ORDER BY posts.created_at DESC;
            ")->fetchAll();

        $tags = $this->model("Tag")->find();
        if($tags){
            $data['tags'] = $tags;
        }

        if($posts) {
            $data['posts'] = $posts;
        }

        $this->view("home", $data);
    }

    public function showLoginPage() {
        $this->view("login");
    }

    public function login() {
        $error = '';
        $user = '';
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        if(!$email || !$password){
            $error = 'Email or password required';
        }
        if(!$error){
            $user = $this->model("User")->findOne("email='$email'");
            if(!$user || !password_verify($password, $user['password'])){
                $error = "Email or password invalid";
            }
        }
        if($error){
            $this->view("login", [
                'error' => $error
            ]);
        }else{
            $_SESSION['id'] = $user["id"];
            $_SESSION['name'] = $user["name"];
            $_SESSION['email'] = $user["email"];

            Route::redirect("/");
        }
    }

    public function logout() {
        unset($_SESSION['id']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        Route::redirect("/");
    }

    public function showSignup() {
        $this->view("signup");
    }

    public function signup() {
        $error = '';
        $name = $_REQUEST['name'];
        $email = $_REQUEST['email'];
        if($_REQUEST['password'] !== $_REQUEST['confirm']){
            $error = "Password confirm invalid";
        }
        $checkEmail = $this->model("User")->find("email='$email'");

        if(count($checkEmail) > 0){
            $error = "Email used";
        }
        $password= password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
        if(!$error){
            $data = $this->model("User")->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password');");
            if(!$data){
                $error = "Cannot sign up, please try again";
            }
        }

        if($error){
            $this->view("signup", [
                "error" => $error
            ]);
        } else {
            $this->view("signup", [
                "signup_success" => "Sign up successfully!"
            ]);
        }
    }
}