<?php
declare(strict_types=1);

namespace tests\Services;

use PHPUnit\Framework\TestCase;
use App\Services\AuthService;
use App\Repositories\UserRepository;
use App\Entities\User;

final class AuthServiceTest extends TestCase
{
    private AuthService $authService;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->authService = new AuthService($this->userRepository);
    }

    public function testRegisterWithCorrectData(): void
    {
        $this->userRepository->method('emailExists')
            ->with('test@example.com')
            ->willReturn(false);

        $this->userRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class))
            ->willReturn(true);

        $result = $this->authService->register([
                'first_name' => 'TestName',
                'last_name' => 'TestSurname',
                'email' => 'test@example.com',
                'phone' => '123456789',
                'password' => '123456'
            ]);

        $this->assertTrue($result);
    }

    public function testRegisterWithExistingEmail(): void
    {
        $this->userRepository->method('emailExists')
            ->with('test@example.com')
            ->willReturn(true);

        $this->userRepository->expects($this->never())
            ->method('save');

        $result = $this->authService->register([
            'first_name' => 'TestName',
            'last_name' => 'TestSurname',
            'email' => 'test@example.com',
            'phone' => '123456789',
            'password' => '123456'
        ]);

        $this->assertFalse($result);
    }

    public function testRegisterWhenSaveFails(): void
    {
        $this->userRepository->method('emailExists')
            ->with('test@example.com')
            ->willReturn(false);


        $this->userRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class))
            ->willReturn(false);

        $result = $this->authService->register([
            'first_name' => 'TestName',
            'last_name' => 'TestSurname',
            'email' => 'test@example.com',
            'phone' => '123456789',
            'password' => '123456'
        ]);

        $this->assertFalse($result);
    }

    public function testLoginWithCorrectCredentials(): void
    {
        $this->userRepository->method('findByEmail')
            ->willReturn(new User('TestName',
                'TestSurname',
                'test@example.com',
                '123456789',
                password_hash('123456', PASSWORD_DEFAULT),
            ));

        $result = $this->authService->login('test@example.com', '123456');
        $this->assertInstanceOf(User::class, $result);
    }

    public function testLoginWithIncorrectPassword(): void
    {
        $this->userRepository->method('findByEmail')
            ->willReturn(new User('TestName',
                'TestSurname',
                'test@example.com',
                '123456789',
                password_hash('123456', PASSWORD_DEFAULT),
            ));

        $result = $this->authService->login('test@example.com', 'wrongpassword');
        $this->assertNull($result);
    }

    public function testLoginWithIncorrectEmail(): void
    {
        $this->userRepository->method('findByEmail')
            ->willReturn(null);

        $result = $this->authService->login('111111', 'wrongpassword');
        $this->assertNull($result);
    }
}
