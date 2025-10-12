<?php
declare(strict_types=1);

namespace tests\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Session;

class SessionTest extends TestCase
{
    protected function tearDown(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $_SESSION = [];
    }

    public function testSetAndGetValue(): void
    {
        Session::set('user_id', 123);

        $this->assertEquals(123, Session::get('user_id'));
    }

    public function testHasReturnsCorrectStatus(): void
    {
        $this->assertFalse(Session::has('some_key'));

        Session::set('some_key', 'value');

        $this->assertTrue(Session::has('some_key'));
    }

    public function testRemoveDeletesKey(): void
    {
        Session::set('temp', 'value');
        $this->assertTrue(Session::has('temp'));

        Session::remove('temp');

        $this->assertFalse(Session::has('temp'));
    }

    public function testClearRemovesAllData(): void
    {
        Session::set('key1', 'value1');
        Session::set('key2', 'value2');

        Session::clear();

        $this->assertFalse(Session::has('key1'));
        $this->assertFalse(Session::has('key2'));
    }
}