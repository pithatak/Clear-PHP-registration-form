<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Database;
use App\Core\Flash;
use App\Core\Validator;
use App\Repositories\UserRepository;
use App\Services\AuthService;

class RegistrationController

{
    public function showForm(): void
    {
        include __DIR__ . "/../views/register/form.php";
    }

    public function register(): void
    {
        $errors = [];

        if (!Csrf::validateToken($_POST['csrf_token'], 'registration')) {
            Flash::add('error', 'Your session is outdated or the request is invalid. Try again.');
            header('Location: /showRegistrationForm');

            exit;
        }

        $validator = new Validator($_POST, [
            'first_name' => ['required', 'min:3', 'max:15', 'alpha'],
            'last_name' => ['required', 'min:3', 'max:15', 'alpha'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'length:9', 'numeric'],
            'password' => ['required', 'min:6', 'max:15'],
        ]);


        $name = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        if (!$validator->passes()) {
            $errors = $validator->errors();
        }

        $db = Database::getConnection();
        $userRepository = new UserRepository($db);

        if ($userRepository->emailExists($email)) {
            $errors['email'][] = 'User with this E-mail already exist';
        }

        if (!empty($errors)) {
            include __DIR__ . "/../views/register/form.php";

            return;
        }

        $authService = new AuthService($userRepository);
        $register = $authService->register([
            'first_name' => $name,
            'last_name'  => $lastName,
            'email'      => $email,
            'phone'      => $phone,
            'password'   => $password,
        ]);

        if ($register) {
            Flash::add('success', 'Registration success!');

            include __DIR__ . "/../views/register/success.php";

            return;
        }

        Flash::add('error', 'Registration error. Please try again.');

        include __DIR__ . "/../views/register/form.php";
    }
}