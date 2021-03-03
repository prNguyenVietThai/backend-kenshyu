<?php
    class Database {
        private $dbHost = "localhost";
        private $dbUser = "root";
        private $dbPass = "root";
        private $dbName = "mydb";

        public $dbHandler;
        public $error;

        public function __construct() {
            $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
            try {
                $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }
    }
