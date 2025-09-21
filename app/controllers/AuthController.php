<?php

require_once __DIR__ . "/../models/User.php";

class AuthController
{
    public function login()
    {
        $message = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->getConnection();

            $user = new User($db);
            $email = $_POST['email'];
            $password = $_POST['password'];

            $authUser = $user->authenticate($email, $password);
            if ($authUser) {
                session_start();
                $_SESSION['user_id'] = $authUser['id'];
                header("Location: index.php?page=dashboard");
                exit;

            } else {
                $error = "Incorrect E-mail or password!";
            }
        }

        if (isset($_GET['message']) && $_GET['message'] === 'access_denied') {
            $error = "Please log in to access your personal account.";
        }

        include __DIR__ . "/../views/login.php";
    }
}