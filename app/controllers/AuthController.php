<?php

use core\Database;
use core\Validator;

class AuthController
{
    public function showForm()
    {
        if (isset($_GET['message']) && $_GET['message'] === 'access_denied') {
            $error = "Please log in to access your personal account.";
        }

        include __DIR__ . "/../views/login.php";
    }

    public function login()
    {
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
            header("Location: /dashboard");
            exit;

        } else {
            $error = "Incorrect E-mail or password!";
        }

        include __DIR__ . "/../views/login.php";
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: /showLoginForm");
        exit();
    }
}