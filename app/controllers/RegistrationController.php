<?php

require_once __DIR__ . "/../models/User.php";

class RegistrationController

{
    public function showForm() {
        include __DIR__ . "/../views/register.php";
    }
    public function register()
    {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->email = $_POST['email'];
        $user->phone = $_POST['phone'];
        $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if ($user->emailExists($user->email)) {
            $error = 'User with this E-mail already exist';
        } else {
            if ($user->register()) {
                $message = 'Registration success!';
            } else {
                $error = 'Registration error.';
            }
        }

        include __DIR__ . "/../views/register.php";
    }
}