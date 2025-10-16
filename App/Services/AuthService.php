<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Validator;
use App\Entities\User;
use App\Repositories\UserRepository;

class AuthService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
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


    public function validateLoginData(?array $data = null): array
    {
        $validator = new Validator($data, [
            'email' => ['required', 'email', 'min:5', 'max:255'],
            'password' => ['required', 'min:6', 'max:15']
        ]);

        if (!$validator->passes()) {
            $errors = $validator->errors();
        }else {
            $errors = [];
        }

        return $errors;
    }

    public function validateRegisterData(?array $data = null): array
    {
        $validator = new Validator($data, [
            'first_name' => ['required', 'min:3', 'max:15', 'alpha'],
            'last_name' => ['required', 'min:3', 'max:15', 'alpha'],
            'email' => ['required', 'email', 'min:5', 'max:255'],
            'phone' => ['required', 'length:9', 'numeric'],
            'password' => ['required', 'min:6', 'max:15'],
        ]);


        if (!$validator->passes()) {
            $errors = $validator->errors();
        }else {
            $errors = [];
        }

        if ($this->userRepository->emailExists($data['email'])) {
            $errors['email'][] = 'User with this E-mail already exist';
        }

        return $errors;
    }
}
