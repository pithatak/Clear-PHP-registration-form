<?php
declare(strict_types=1);

namespace tests\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Flash;
use App\Core\Session;

class FlashTest extends TestCase
{
    protected function setUp(): void
    {
        Session::clear();
    }

    protected function tearDown(): void
    {
        Session::clear();
    }

    public function testAddStoresMessageInSession(): void
    {
        Flash::add('success', 'Registration successful!');

        $flashes = Session::get('flash');
        $this->assertArrayHasKey('success', $flashes);
        $this->assertEquals('Registration successful!', $flashes['success']);
    }

    public function testGetReturnsMessageAndRemovesIt(): void
    {
        Flash::add('error', 'Invalid email');

        $message = Flash::get('error');

        $this->assertEquals('Invalid email', $message);

        $this->assertNull(Flash::get('error'));
        $this->assertFalse(Flash::has('error'));
    }

    public function testGetReturnsNullForNonExistentType(): void
    {
        $message = Flash::get('nonexistent');

        $this->assertNull($message);
    }

    public function testHasReturnsCorrectStatus(): void
    {
        $this->assertFalse(Flash::has('info'));

        Flash::add('info', 'Some message');

        $this->assertTrue(Flash::has('info'));
    }

    public function testMultipleMessagesOfDifferentTypes(): void
    {
        Flash::add('success', 'Success message');
        Flash::add('error', 'Error message');

        $this->assertTrue(Flash::has('success'));
        $this->assertTrue(Flash::has('error'));
        $this->assertEquals('Success message', Flash::get('success'));
        $this->assertEquals('Error message', Flash::get('error'));
    }

    public function testMessageIsRemovedAfterGet(): void
    {
        Flash::add('warning', 'Warning message');

        $firstCall = Flash::get('warning');
        $this->assertEquals('Warning message', $firstCall);

        $secondCall = Flash::get('warning');
        $this->assertNull($secondCall);
    }
}