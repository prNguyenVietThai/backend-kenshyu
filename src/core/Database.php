<?php
    class Database {
        private $dbHost;
        private $dbUser;
        private $dbPass;
        private $dbName;
        public $dbHandler;
        public $pdo;
        public $error;

        public function __construct() {
            $this->dbHost = $_ENV['HOST'];
            $this->dbUser = $_ENV['USER'];
            $this->dbPass = $_ENV['PASS'];
            $this->dbName = $_ENV['DATABASE'];

            $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
            try {
                $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => true
                ));
                $this->pdo = new PDO($conn, $this->dbUser, $this->dbPass, array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => true
                ));
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }
    }
