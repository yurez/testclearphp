<?php
namespace TestClearPhpTest\Unit\Service;

use PHPUnit\Framework\TestCase;
use TestClearPhp\Core\Request;
use TestClearPhp\Exception\ValidationException;
use TestClearPhp\Model\User;
use TestClearPhp\Service\RegistrationFormProcessor;
use TestClearPhp\Service\UserManager;

class RegistrationFormProcessorTest extends TestCase
{
    public function testProcessWithValidData(): void
    {
        $userManagerMock = $this->createMock(UserManager::class);
        $userManagerMock->method('loadUser')->willReturn(null);
        $userManagerMock->method('createUser')->willReturn(new User());

        $formData = [
            'email' => 'test@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'plain_password' => 'password123',
            'plain_password2' => 'password123',
            'phone' => '123456789',
        ];

        $request = new Request($formData, [], ['REQUEST_METHOD' => 'POST']);

        $processor = new RegistrationFormProcessor($userManagerMock);

        $user = $processor->process($request);

        $this->assertInstanceOf(User::class, $user);
    }

    public function testProcessWithEmptyData(): void
    {
        $userManagerMock = $this->createMock(UserManager::class);
        $userManagerMock->method('loadUser')->willReturn(null);

        $formData = [
            // Provide invalid form data here to trigger validation errors
        ];

        $request = new Request($formData, [], ['REQUEST_METHOD' => 'POST']);

        $processor = new RegistrationFormProcessor($userManagerMock);

        try {
            $processor->process($request);
        } catch (ValidationException $e) {
            $this->assertNotEmpty($errors = $e->getErrors());
        }

        $this->assertTrue(isset($e), 'Exception should throw');

        $this->assertArrayHasKey('email', $errors);
        $this->assertEquals('Email is required', $errors['email'] );
        $this->assertArrayHasKey('first name', $errors);
        $this->assertEquals('First name is required', $errors['first name']);
        $this->assertArrayHasKey('last name', $errors);
        $this->assertEquals('Last name is required', $errors['last name']);
        $this->assertArrayHasKey('password', $errors);
        $this->assertEquals('Password is required', $errors['password']);
    }

    public function testProcessWithInvalidData(): void
    {
        $userManagerMock = $this->createMock(UserManager::class);
        $userManagerMock->method('loadUser')->willReturn(null);

        $formData = [
            'email' => 'fdfdfd',
            'plain_password' => '12345',
            'first_mame' => 'Test',
            'last_name' => 'Last'
        ];

        $request = new Request($formData, [], ['REQUEST_METHOD' => 'POST']);

        $processor = new RegistrationFormProcessor($userManagerMock);

        try {
            $processor->process($request);
        } catch (ValidationException $e) {
            $this->assertNotEmpty($errors = $e->getErrors());
        }

        $this->assertTrue(isset($e), 'Exception should throw');

        $this->assertArrayHasKey('email', $errors);
        $this->assertEquals('Invalid email format', $errors['email'] );
        $this->assertArrayHasKey('password', $errors);
        $this->assertEquals('Password should be at least 6 characters long', $errors['password']);
    }
}
