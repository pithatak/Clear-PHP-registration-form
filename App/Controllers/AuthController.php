<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Database;
use App\Core\Flash;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Repositories\UserRepository;
use App\Services\AuthService;

class AuthController
{
    private AuthService $authService;

    public function __construct(?AuthService $authService = null)
    {
        $this->authService = $authService ?? new AuthService(new UserRepository(Database::getConnection()));
    }

    public function showForm(Request $request): Response
    {
        return new Response(__DIR__ . '/../views/login.php');
    }

    public function login(Request $request): Response
    {
        $data = $request->getPost();
        $errors = [];

        if (!Csrf::validateToken($data['csrf_token'], 'login')) {
            Flash::add('error', 'Your session is outdated or the request is invalid. Try again.');

            return new Response(redirect: '/showLoginForm');
        }

        $errors = $this->authService->validateLoginData($data);
        if ($errors) {
            $errors['upper_form'] = "Incorrect E-mail or password!";

            return new Response(__DIR__ . '/../views/login.php', [
                'data' => $data,
                'errors' => $errors
            ]);
        }

        $user = $this->authService->login($data['email'], $data['password']);

        if ($user) {
            Session::start();
            Session::regenerate(true);
            Session::set('user_id', $user->getId());

            Flash::add('success', 'You are now logged in.');

            return new Response(redirect: '/dashboard');
        } else {
            $errors['upper_form'] = "Incorrect E-mail or password!";
        }

        return new Response(__DIR__ . '/../views/login.php', ['errors' => $errors]);
    }

    public function logout(): Response
    {
        Session::destroy();

        return new Response(redirect: '/showLoginForm');
    }
}
