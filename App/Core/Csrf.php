<?php
declare(strict_types=1);

namespace App\Core;

use App\Core\Session;

class Csrf
{
    private const DEFAULT_TOKEN_KEY = 'csrf_token';
    private const TOKEN_LIFETIME = 3600;


    public static function generateToken(string $key = self::DEFAULT_TOKEN_KEY): string
    {
        $token = bin2hex(random_bytes(32));
        $expiresAt = time() + self::TOKEN_LIFETIME;

        Session::set($key, [
            'token' => $token,
            'expires_at' => $expiresAt
        ]);

        return $token;
    }

    public static function validateToken(?string $token, string $key = self::DEFAULT_TOKEN_KEY): bool
    {
        if (!$token) {

            return false;
        }

        self::cleanupExpiredToken($key);

        $storedToken = Session::get($key);

        if (!$storedToken || !isset($storedToken['token'], $storedToken['expires_at'])) {

            return false;
        }

        $isValid = hash_equals($storedToken['token'], $token);

        if ($isValid) {
            Session::remove($key);
        }

        return $isValid;
    }

    private static function cleanupExpiredToken(string $key): void
    {
        if (Session::has($key)) {
            $storedToken = Session::get($key);
            if (time() > $storedToken['expires_at']) {
                Session::remove($key);
            }
        }
    }

    public static function getTokenField(string $key = self::DEFAULT_TOKEN_KEY): string
    {
        return '<input type="hidden" name="csrf_token" value="' . self::generateToken($key) . '">';
    }
}