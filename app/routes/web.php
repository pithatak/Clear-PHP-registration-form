<?php

$router = new App\Router();

$router->get('/showRegistrationForm', ['App\Controllers\RegistrationController', 'showForm']);
$router->post('/register', ['App\Controllers\RegistrationController', 'register']);

$router->get('/showLoginForm', ['App\Controllers\AuthController', 'showForm']);
$router->get('/logout', ['App\Controllers\AuthController', 'logout']);
$router->post('/login', ['App\Controllers\AuthController', 'login']);

$router->get('/dashboard', ['App\Controllers\DashboardController', 'showUserInformation']);

$router->get('/', ['App\Controllers\HomeController', 'index']);

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));