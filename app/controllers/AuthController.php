<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Database;
use App\Core\Flash;
use App\Core\Session;
use App\Core\Validator;
use App\Repositories\UserRepository;
use App\Services\AuthService;

class AuthController
{
    public function showForm(): void
    {
        include __DIR__ . "/../views/login.php";
    }

    public function login(): void
    {
        $errors = [];

        if (!Csrf::validateToken($_POST['csrf_token'], 'login')) {
            Flash::add('error', 'Your session is outdated or the request is invalid. Try again.');
            header('Location: /showLoginForm');

            exit;
        }

        $validator = new Validator($_POST, [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:15']
        ]);

        $email = $_POST['email'];

        if (!$validator->passes()) {
            $errors = $validator->errors();

            include __DIR__ . "/../views/login.php";

            return;
        }

        $db = Database::getConnection();
        $userRepository = new UserRepository($db);
        $authService = new AuthService($userRepository);

        $password = $_POST['password'];

        $authUser = $authService->login($email, $password);

        if ($authUser) {
            Session::start();
            Session::regenerate(true);
            Session::set('user_id', $authUser->getId());

            Flash::add('success', 'You are now logged in.');
            header("Location: /dashboard");

            exit;
        } else {
            $errors['upper_form'] = "Incorrect E-mail or password!";
        }

        include __DIR__ . "/../views/login.php";
    }

    public function logout(): void
    {
        Session::destroy();
        header("Location: /showLoginForm");

        exit();
    }
}