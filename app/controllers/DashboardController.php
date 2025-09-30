<?php

use core\Database;

class DashboardController
{
    public function showUserInformation()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login&message=access_denied");
            exit;
        }

        $db = Database::getConnection();

        $user = new User($db);

        $userData = $user->findById($_SESSION['user_id']);

        include __DIR__ . "/../views/dashboard.php";
    }
}
