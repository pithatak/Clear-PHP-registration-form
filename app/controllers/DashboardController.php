<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Models\User;

class DashboardController
{
    public function showUserInformation(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /showLoginForm?message=access_denied");
            exit;
        }

        $db = Database::getConnection();

        $user = new User($db);

        $userData = $user->findById($_SESSION['user_id']);

        include __DIR__ . "/../views/dashboard.php";
    }
}
