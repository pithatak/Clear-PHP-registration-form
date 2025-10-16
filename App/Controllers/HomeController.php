<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response;

class HomeController
{
    public function index(): Response
    {
        return new Response(__DIR__ . "/../views/main.php");
    }
}