<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Flash;
use App\Core\Response;
use App\Core\Session;
use App\Repositories\UserRepository;

class DashboardController
{
    private UserRepository $userRepository;

    public function __construct(?UserRepository $userRepository = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository(Database::getConnection());
    }

    public function showUserInformation(): Response
    {
        if (!Session::has('user_id')) {
            Flash::add('error', 'Please log in to access your personal account.');

            return new Response(redirect: "/showLoginForm");
        }

        $user = $this->userRepository->getCurrentUser();

        if (!$user) {
            Session::destroy();
            Flash::add('error', 'User not found. Please log in again.');
            return new Response(redirect: "/showLoginForm");
        }

        return new Response(__DIR__ . "/../views/dashboard.php", [
            'user' => $user
        ]);
    }
}
