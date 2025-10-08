<?php
declare(strict_types=1);

namespace App\Services;

use App\Entities\User;
use App\Repositories\UserRepository;

class AuthService
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): bool
    {
        if ($this->userRepository->emailExists($data['email'])) {

            return false;
        }

        $user = new User(
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        );

        return $this->userRepository->save($user);
    }

    public function login(string $email, string $password): ?User
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user || !password_verify($password, $user->getPasswordHash())) {

            return null;
        }

        return $user;
    }
}
