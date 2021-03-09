<?php
    class Model
    {
        public $db, $modelName;

        public function __construct()
        {
            $this->db = new Database();
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