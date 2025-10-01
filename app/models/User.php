<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class User
{
    private PDO $connection;
    private string $table_name = "users";
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $phone;
    private string $password;

    public function __construct(PDO $db)
    {
        $this->connection = $db;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


    public function register(): bool
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

    public function emailExists(string $email): bool
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function authenticate(string $email, string $password): array|false
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

    public function findById(int $id): array|false
    {
        $query = 'SELECT id, first_name, last_name, phone, email FROM users WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}