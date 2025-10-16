<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Database;
use App\Core\Flash;
use App\Core\Request;
use App\Core\Response;
use App\Repositories\UserRepository;
use App\Services\AuthService;

class RegistrationController
{

    private AuthService $authService;

    public function __construct(?AuthService $authService = null)
    {
        $this->authService = $authService ?? new AuthService(new UserRepository(Database::getConnection()));
    }

    public function showForm(): Response
    {
        return new Response(__DIR__ . "/../views/register/form.php");
    }

    public function register(Request $request): Response
    {
        $data = $request->getPost();

        $errors = [];

        if (!Csrf::validateToken($_POST['csrf_token'], 'registration')) {
            Flash::add('error', 'Your session is outdated or the request is invalid. Try again.');

            return new Response(redirect: "/showRegistrationForm");
        }

        $errors =  $this->authService->validateRegisterData($data);
        if ($errors) {

            return new Response(__DIR__ . '/../views/register/form.php', [
                'data' => $data,
                'errors' => $errors
            ]);
        }

        $register = $this->authService->register($data);

        if ($register) {
            Flash::add('success', 'Registration success!');

            return new Response(redirect: '/showRegistrationSuccess');
        }

        Flash::add('error', 'Registration error. Please try again.');

        return new Response(__DIR__ . '/../views/register/form.php');
    }

    public function showSuccess(): Response
    {
        return new Response(__DIR__ . '/../views/register/success.php');
    }
}