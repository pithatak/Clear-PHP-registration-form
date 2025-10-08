<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Flash;
use App\Core\Session;
use App\Repositories\UserRepository;

class DashboardController
{
    public function showUserInformation(): void
    {
        if (!Session::has('user_id')) {
            Flash::add('error', 'Please log in to access your personal account.');

            header("Location: /showLoginForm");
            exit;
        }

        $db = Database::getConnection();
        $userRepository = new UserRepository($db);

        $user = $userRepository->findById(Session::get('user_id'));

        include __DIR__ . "/../views/dashboard.php";
    }
}
