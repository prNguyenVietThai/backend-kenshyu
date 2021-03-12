<?php
class UserServices extends Services {
    public function __construct(){
        $this->model = $this->model("User");
    }

    public function getById(int $id){
        $query = "SELECT * FROM users WHERE id=:id";
        $conn = $this->model->pdo;
        $set = $conn->prepare($query);
        $set->bindParam(':id', $id, PDO::PARAM_INT);
        $set->execute();
        if(!$set){
            return false;
        }

        return $set->fetch();
    }

    public function getByEmail(string $email){
        $query = "SELECT * FROM users WHERE email=:email";
        $conn = $this->model->pdo;
        $set = $conn->prepare($query);
        $set->bindParam(':email', $email, PDO::PARAM_STR);
        $set->execute();

        if(!$set){
            return false;
        }

        return $set->fetch();
    }

    public function create(array $user=[]){
        $name = (string)$user['name'];
        $email = (string)$user['email'];
        $password = (string)$user['password'];

        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password);";

        $conn = $this->model->pdo;
        $set = $conn->prepare($query);
        $set->bindParam(':name', $name, PDO::PARAM_STR);
        $set->bindParam(':email', $email, PDO::PARAM_STR);
        $set->bindParam(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $set->execute();
        $userId = $conn->lastInsertId();

        return $this->getById($userId);
    }
}