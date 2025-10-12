<?php
declare(strict_types=1);

namespace tests\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Csrf;
use App\Core\Session;

class CsrfTest extends TestCase
{
    protected function setUp(): void
    {
        Session::clear();
    }
    protected function tearDown(): void
    {
        Session::clear();
    }

    public function testGenerateTokenCreatesValidToken(): void
    {
        $token = Csrf::generateToken();

        $this->assertIsString($token);
        $this->assertEquals(64, strlen($token));

        $stored = Session::get('csrf_token');
        $this->assertIsArray($stored);
        $this->assertEquals($token, $stored['token']);
    }

    public function testValidateTokenReturnsTrueForValidToken(): void
    {
        $originalToken = Csrf::generateToken();

        $result = Csrf::validateToken($originalToken);

        $this->assertTrue($result);
        $this->assertFalse(Session::has('csrf_token'));
    }

    public function testValidateTokenReturnsFalseForInvalidToken(): void
    {
        Csrf::generateToken();

        $result = Csrf::validateToken('invalid_token');

        $this->assertFalse($result);
    }

    public function testValidateTokenReturnsFalseForExpiredToken(): void
    {
        Session::set('csrf_token', [
            'token' => 'test_token',
            'expires_at' => time() - 1000
        ]);

        $result = Csrf::validateToken('test_token');

        $this->assertFalse($result);
        $this->assertFalse(Session::has('csrf_token'));
    }

    public function testValidateTokenReturnsFalseForNullToken(): void
    {
        Csrf::generateToken();

        $result = Csrf::validateToken(null);

        $this->assertFalse($result);
    }

    public function testGetTokenFieldReturnsHtmlInput(): void
    {
        $html = Csrf::getTokenField();

        $this->assertStringContainsString('<input type="hidden"', $html);
        $this->assertStringContainsString('name="csrf_token"', $html);
        $this->assertStringContainsString('value="', $html);
    }

    public function testDifferentKeysGenerateDifferentTokens(): void
    {
        $token1 = Csrf::generateToken('key1');
        $token2 = Csrf::generateToken('key2');

        $this->assertNotEquals($token1, $token2);
        $this->assertTrue(Session::has('key1'));
        $this->assertTrue(Session::has('key2'));
    }
}