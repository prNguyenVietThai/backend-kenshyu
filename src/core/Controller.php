<?php
    class Controller {
        public function __construct()
        {

        }

        public function view($view, $data = []) {
            if (file_exists('./views/' . $view . '.php')) {
                include_once './views/' . $view . '.php';
            }
        }

        public function response($status=200, $data = []) {
            http_response_code($status);
            echo json_encode($data);
        }
    }