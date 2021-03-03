<?php
    class Model {
        public $db, $modelName, $query, $options;

        public function __construct()
        {
            $this->db = new Database();
            $this->options = "";
        }

        public function find(string $options = "")
        {
            if(!$options) {
                $data = $this->query("SELECT * FROM $this->modelName")->fetchAll();
                return $data;
            } else {
                $data = $this->query("SELECT * FROM $this->modelName WHERE $options")->fetchAll();
                return $data;
            }
        }

        public function findOne(string $options)
        {
            $data = $this->query("SELECT * FROM " . $this->modelName)->fetchAll();
            return $data;
        }

        private function query($queryString)
        {
            return $this->db->dbHandler->query($queryString);
        }
    }