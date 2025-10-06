<?php

namespace App\Core;

class Flash
{
    private static function ensureSessionStarted(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function add(string $type, string $message): void
    {
        self::ensureSessionStarted();

        $_SESSION['flash'][$type] = $message;
    }

    public static function get(string $type): ?string
    {
        self::ensureSessionStarted();

        $msg = $_SESSION['flash'][$type] ?? null;

        if (!isset($msg)) {

            return null;
        }

        unset($_SESSION['flash'][$type]);

        return $msg;
    }

    public static function has(string $type): bool
    {
        self::ensureSessionStarted();

        return !empty($_SESSION['flash'][$type]);
    }
}