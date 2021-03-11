<?php
include_once __DIR__."/../services/PostServices.php";
include_once __DIR__."/../services/TagServices.php";
include_once __DIR__."/../services/UserServices.php";

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
        $postService = new PostServices();
        $posts = $postService->getAll();
        $tagService = new TagServices();
        $tags = $tagService->getAll();
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
        $email = (string)$_REQUEST['email'];
        $password = (string)$_REQUEST['password'];
        if(!$email || !$password){
            $error = 'Email or password required';
        }
        if(!$error){
            $userService = new UserServices();
            $user = $userService->getByEmail($email);
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
        $password = $_POST['password'];
        if($_REQUEST['password'] !== $_REQUEST['confirm']){
            $error = "Password confirm invalid";
        }
        $userService = new UserServices();
        $checkEmail = $userService->getByEmail($email);

        if($checkEmail){
            $error = "Email used";
        }

        if(!$error){
            $data = $userService->create([
                "name" => $name,
                "email" => $email,
                "password" => $password
            ]);
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