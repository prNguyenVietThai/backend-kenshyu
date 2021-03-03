<?php
class AuthController extends Controller {
    public function __construct() {
        $this->model = $this->model("User");
    }

    public function showLoginPage() {
        $this->view("login");
    }

    public function login() {
        echo "Login user";
    }

    public function signup() {
        $this->view("signup");
    }
}