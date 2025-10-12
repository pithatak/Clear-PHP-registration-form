<?php
declare(strict_types=1);

namespace tests\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Validator;

final class ValidatorCoreTest extends TestCase
{
    public function testPassesWithValidData(): void
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Gold',
            'email' => 'JohnyGoldy@gmail.com',
            'phone' => '987654321',
            'password' => '666666'
        ];

        $rules = [
            'first_name' => ['required', 'min:3', 'max:15', 'alpha'],
            'last_name' => ['required', 'min:3', 'max:15', 'alpha'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'length:9', 'numeric'],
            'password' => ['required', 'min:6', 'max:15'],
        ];

        $validator = new Validator($data, $rules);

        $this->assertTrue($validator->passes());
        $this->assertEmpty($validator->errors());
    }

    public function testFailsOnRequiredField(): void
    {
        $data = ['email' => ''];
        $rules = ['email' => ['required']];

        $validator = new Validator($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('email', $validator->errors());
        $this->assertStringContainsString('required', $validator->errors()['email'][0]);
    }

    public function testFailsOnInvalidEmail(): void
    {
        $data = ['email' => 'invalid-email'];
        $rules = ['email' => ['email']];

        $validator = new Validator($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('email', $validator->errors());
    }

    public function testFailsOnMinLength(): void
    {
        $data = ['password' => '123'];
        $rules = ['password' => ['min:6']];

        $validator = new Validator($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('password', $validator->errors());
    }

    public function testFailsOnMaxLength(): void
    {
        $data = ['password' => 'VeryLongPasswordThatExceedsLimit'];
        $rules = ['password' => ['max:15']];

        $validator = new Validator($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('password', $validator->errors());
    }

    public function testFailsOnExactLength(): void
    {
        $data = ['phone' => '123'];
        $rules = ['phone' => ['length:9']];

        $validator = new Validator($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('phone', $validator->errors());
    }

    public function testFailsOnNonAlpha(): void
    {
        $data = ['name' => 'John123'];
        $rules = ['name' => ['alpha']];

        $validator = new Validator($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('name', $validator->errors());
    }

    public function testFailsOnNonNumeric(): void
    {
        $data = ['phone' => '25years'];
        $rules = ['phone' => ['numeric']];

        $validator = new Validator($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('phone', $validator->errors());
    }

    public function testStopsOnFirstErrorForField(): void
    {
        $data = ['email' => ''];
        $rules = ['email' => ['required', 'email']];

        $validator = new Validator($data, $rules);

        $this->assertCount(1, $validator->errors()['email']);
        $this->assertArrayHasKey('email', $validator->errors());
    }

    public function testTrimsValuesBeforeValidation(): void
    {
        $data = ['name' => '  John  '];
        $rules = ['name' => ['alpha']];

        $validator = new Validator($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function testHandlesMissingFieldsGracefully(): void
    {
        $data = [];
        $rules = ['email' => ['required']];

        $validator = new Validator($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('email', $validator->errors());
    }
}