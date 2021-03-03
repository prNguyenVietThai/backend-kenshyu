<?php
    class UserController extends Controller {
        public function __construct() {
            $this->model = $this->model("User");
        }

        public function index() {
            $data = $this->model("User")->find("email='nguyenvietthai1351997@gmail.com'");
            var_dump($data);
        }
    }