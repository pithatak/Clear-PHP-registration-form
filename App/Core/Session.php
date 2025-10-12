<?php
declare(strict_types=1);

namespace App\Core;

class Session
{
    public static function start(array $options = []): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start($options);
        }
    }

    public static function ensureStarted(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void
    {
        self::ensureStarted();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, $default = null): mixed
    {
        self::ensureStarted();

        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        self::ensureStarted();

        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        self::ensureStarted();
        unset($_SESSION[$key]);
    }

    public static function clear(): void
    {
        self::ensureStarted();
        session_unset();

        $_SESSION = [];
    }

    public static function destroy(): void
    {

        self::ensureStarted();

        session_unset();
        session_destroy();
        session_write_close();
    }

    public static function regenerate($delete_old_session = false): void
    {
        session_regenerate_id($delete_old_session);
    }
}