<?php

namespace App\Models;

use PDO;

class User
{
    private $connection;
    private $table_name = "users";

    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $password;

    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function register()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  (first_name, last_name, email, phone, password) 
                  VALUES (:first_name, :last_name, :email, :phone, :password)";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":password", $this->password);

        return $stmt->execute();
    }

    public function emailExists($email)
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function authenticate($email, $password)
    {
        $query = 'SELECT * FROM ' . $this->table_name . ' WHERE email = :email LIMIT 1';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function findById($id)
    {
        $query = 'SELECT id, first_name, last_name, phone, email FROM users WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}