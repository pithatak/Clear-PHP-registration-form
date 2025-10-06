<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Validator;
use App\Models\User;
use App\Core\Csrf;
use App\Core\Flash;

class AuthController
{
    public function showForm(): void
    {
        include __DIR__ . "/../views/login.php";
    }

    public function login(): void
    {

        $token = $_POST['csrf_token'] ?? null;

        if (!Csrf::validateToken($token, 'login')) {
            Flash::add('error', 'Your session is outdated or the request is invalid. Try again.');
            header('Location: /login');

            exit;
        }

        $validator = new Validator($_POST, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $email = $_POST['email'];

        if (!$validator->passes()) {
            $errors = $validator->errors();

            include __DIR__ . "/../views/login.php";

            return;
        }

        $db = Database::getConnection();
        $user = new User($db);
        $password = $_POST['password'];

        $authUser = $user->authenticate($email, $password);
        if ($authUser) {
            session_start();
            $_SESSION['user_id'] = $authUser['id'];

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
        session_start();
        session_unset();
        session_destroy();

        header("Location: /showLoginForm");
        exit();
    }
}