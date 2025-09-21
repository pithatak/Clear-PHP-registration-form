<?php
require_once __DIR__ . "/../config/database.php";

$page = $_GET['page'];

switch ($page) {
    case 'register':
        require_once __DIR__ . "/../app/controllers/RegistrationController.php";

        $controller = new RegistrationController();
        $controller->register();
        break;
    case 'login':
        require_once __DIR__ . "/../app/controllers/AuthController.php";

        $controller = new AuthController();
        $controller->login();
        break;
    case 'dashboard':
        require_once __DIR__ . "/../app/controllers/DashboardController.php";

        $controller = new DashboardController();
        $controller->showUserInformation();
        break;
    case 'logout':
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    default:
        include __DIR__ . "/../app/views/main.php";
        break;
}

