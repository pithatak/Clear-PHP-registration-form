<?php
declare(strict_types=1);

$router = new App\Router();
$request = new App\Core\Request($_GET, $_POST, $_SERVER);

$router->get('/showRegistrationForm', ['App\Controllers\RegistrationController', 'showForm']);
$router->post('/register', ['App\Controllers\RegistrationController', 'register']);
$router->get('/showRegistrationSuccess', ['App\Controllers\RegistrationController', 'showSuccess']);

$router->get('/showLoginForm', ['App\Controllers\AuthController', 'showForm']);
$router->get('/logout', ['App\Controllers\AuthController', 'logout']);
$router->post('/login', ['App\Controllers\AuthController', 'login']);

$router->get('/dashboard', ['App\Controllers\DashboardController', 'showUserInformation']);

$router->get('/', ['App\Controllers\HomeController', 'index']);

$router->dispatch($request->method(), $request->path(), $request);