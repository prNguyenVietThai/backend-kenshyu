<?php
    class Model
    {
        public $db, $modelName;

        public function __construct()
        {
            $conn = new Database();
            $this->db = $conn;
            $this->pdo = $conn->pdo;
        }

        public function find(string $options = "")
        {
            $query = "SELECT * FROM $this->modelName";
            if($options){
                $query = $query . " WHERE $options";
            }
            $data = $this->query($query);
            if(!$data) {
                return false;
            }
            return $data->fetchAll();
        }

        public function findById(int $id)
        {
            $query = "SELECT * FROM $this->modelName WHERE id = :id";
            $conn = $this->pdo;
            $set = $conn->prepare($query);
            $set->bindParam(":id", $id);
            $set->execute();

            if(!$set) {
                return false;
            }
            return $set->fetch();
        }

        public function findOne(string $options)
        {
            $data = $this->query("SELECT * FROM $this->modelName WHERE $options");
            if(!$data) {
                return false;
            }
            return $data->fetch();
        }

        public function query($queryString)
        {
            return $this->db->dbHandler->query($queryString);
        }
    }