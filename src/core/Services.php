<?php
class Services {
    public function __construct(){
        $this->db = new Database();
        $this->pdo = $this->db->pdo;
    }

    public function model($model) {
        require_once './models/' . $model . '.php';
        $newModel = new $model();
        $newModel->modelName = strtolower($model)."s";

        return $newModel;
    }
}