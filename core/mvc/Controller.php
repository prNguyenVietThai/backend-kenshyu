<?php
    class Controller {
        public function __construct()
        {
            $this->db = new Database();
        }

        public function model($model) {
            require_once './models/' . $model . '.php';
            $newModel = new $model();
            $newModel->modelName = strtolower($model)."s";

            return $newModel;
        }

        public function view($view, $data = []) {
            if (file_exists('./views/' . $view . '.php')) {
                include './views/' . $view . '.php';
            } else {
                echo("View does not exists.");
            }
        }
    }