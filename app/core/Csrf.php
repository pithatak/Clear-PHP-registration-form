<?php
declare(strict_types=1);

namespace App\Core;

class Csrf
{
    private const DEFAULT_TOKEN_KEY = 'csrf_token';
    private const TOKEN_LIFETIME = 3600;

    private static function ensureSessionStarted(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function generateToken(string $key = self::DEFAULT_TOKEN_KEY): string
    {
        self::ensureSessionStarted();

        $token = bin2hex(random_bytes(32));
        $expiresAt = time() + self::TOKEN_LIFETIME;

        $_SESSION[$key] = [
            'token' => $token,
            'expires_at' => $expiresAt
        ];

        return $token;
    }

    public static function validateToken(?string $token, string $key = self::DEFAULT_TOKEN_KEY): bool
    {
        if (!$token) {

            return false;
        }

        self::ensureSessionStarted();
        self::cleanupExpiredToken($key);

        $storedToken = $_SESSION[$key] ?? null;

        if (!$storedToken || !isset($storedToken['token'], $storedToken['expires_at'])) {

            return false;
        }

        $isValid = hash_equals($storedToken['token'], $token);

        if ($isValid) {
            unset($_SESSION[$key]);
        }

        return $isValid;
    }

    private static function cleanupExpiredToken(string $key): void
    {
        if (!empty($_SESSION[$key])) {
            $storedToken = $_SESSION[$key];
            if (time() > $storedToken['expires_at']) {
                unset($_SESSION[$key]);
            }
        }
    }

    public static function getTokenField(string $key = self::DEFAULT_TOKEN_KEY): string
    {
        return '<input type="hidden" name="csrf_token" value="' . self::generateToken($key) . '">';
    }
}