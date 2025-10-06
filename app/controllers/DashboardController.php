<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Flash;
use App\Models\User;

class DashboardController
{
    public function showUserInformation(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            Flash::add('error', 'Please log in to access your personal account.');

            header("Location: /showLoginForm");
            exit;
        }

        $db = Database::getConnection();

        $user = new User($db);

        $userData = $user->findById($_SESSION['user_id']);

        include __DIR__ . "/../views/dashboard.php";
    }
}
