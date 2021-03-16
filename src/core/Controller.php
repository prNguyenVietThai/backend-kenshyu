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
            $data = $this->refresh($data);
            if (file_exists('./views/' . $view . '.php')) {
                include_once './views/' . $view . '.php';
            }
        }

        public function response($status=200, $data = []) {
            http_response_code($status);
            echo json_encode($this->refresh($data));
        }

        private function escape($data){
            return htmlspecialchars($data, ENT_QUOTES, "UTF-8");
        }

        private function refresh(array $arr=[])
        {
            foreach($arr as $key => $value){
                if(is_array($value)){
                    $arr[$key] = $this->refresh($value);
                }else{
                    $arr[$key] = $this->escape($value);
                }
            }
            return $arr;
        }
    }