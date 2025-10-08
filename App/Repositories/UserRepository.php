<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(User $user): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (first_name, last_name, email, phone, password)
            VALUES (:first_name, :last_name, :email, :phone, :password)
        ");

        return $stmt->execute([
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
            ':email' => $user->getEmail(),
            ':phone' => $user->getPhone(),
            ':password' => $user->getPasswordHash(),
        ]);
    }


    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->mapUser($data);
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);

        return $stmt->rowCount() > 0;
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->mapUser($data);
    }

    private function mapUser(?array $data): ?User
    {
        if (!$data) {

            return null;
        }

        return new User(
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            $data['password'],
            (int)$data['id']
        );
    }

}
