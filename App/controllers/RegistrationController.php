<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Flash;
use App\Core\Validator;
use App\Models\User;
use App\Core\Csrf;

class RegistrationController

{
    public function showForm(): void
    {
        include __DIR__ . "/../views/register/form.php";
    }

    public function register(): void
    {
        $token = $_POST['csrf_token'] ?? null;

        if (!Csrf::validateToken($token, 'registration')) {
            Flash::add('error', 'Your session is outdated or the request is invalid. Try again.');
            header('Location: /showRegistrationForm');

            exit;
        }

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

        if (!empty($errors)) {
            include __DIR__ . "/../views/register/form.php";

            return;
        }

        $user->setFirstName($name);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));

        if ($user->register()) {
            Flash::add('success', 'Registration success!');

            include __DIR__ . "/../views/register/success.php";

            return;
        }

        Flash::add('error', 'Registration error. Please try again.');

        include __DIR__ . "/../views/register/form.php";

    }
}