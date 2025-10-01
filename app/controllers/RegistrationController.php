<?php

use core\Database;
use core\Validator;
class RegistrationController

{
    public function showForm()
    {
        include __DIR__ . "/../views/register/form.php";
    }

    public function register()
    {
        $errors = array();
        $db = Database::getConnection();
        $user = new User($db);

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

        if (!$validator->passes()) {
            $errors = $validator->errors();
        }

        if ($user->emailExists($email)) {
            $errors['email'][] = 'User with this E-mail already exist';
        }

        if (!empty($errors)){
            include __DIR__ . "/../views/register/form.php";

            return;
        }

        $user->first_name = $name;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->phone = $phone;
        $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);


        if ($user->register()) {
            $message = 'Registration success!';
        } else {
            $errors = 'Registration error.';
        }


        include __DIR__ . "/../views/register/success.php";
    }
}