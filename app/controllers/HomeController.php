<?php
declare(strict_types=1);

namespace App\Controllers;

class HomeController
{
    public function index(): void
    {
        include __DIR__ . "/../views/main.php";
    }
}