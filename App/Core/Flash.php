<?php
declare(strict_types=1);

namespace App\Core;

use App\Core\Session;

class Flash
{
    public static function add(string $type, string $message): void
    {
        $flashes = Session::get('flash', []);
        $flashes[$type] = $message;
        Session::set('flash', $flashes);
    }

    public static function get(string $type): ?string
    {
        $flashes = Session::get('flash', []);
        if (!isset($flashes[$type])) {

            return null;
        }

        $message = $flashes[$type];
        unset($flashes[$type]);
        Session::set('flash', $flashes);

        return $message;
    }

    public static function has(string $type): bool
    {
        $flashes = Session::get('flash', []);

        return isset($flashes[$type]);
    }

}