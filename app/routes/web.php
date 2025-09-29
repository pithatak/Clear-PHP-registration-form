<?php

require __DIR__ . '/../Router.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/RegistrationController.php';

$router = new Router();

$router->get('/showRegistrationForm',   ['RegistrationController', 'showForm']);
$router->post('/register',   ['RegistrationController', 'register']);


$router->get('/showLoginForm', ['AuthController', 'showForm']);
$router->get('/logout', ['AuthController', 'logout']);
$router->post('/login', ['AuthController', 'login']);

$router->get('/dashboard', ['DashboardController', 'showUserInformation']);

$router->get('/', ['HomeController', 'index']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);