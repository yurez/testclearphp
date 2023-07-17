<?php

namespace TestClearPhp\Service;

use TestClearPhp\Core\Request;
use TestClearPhp\Exception\ValidationException;
use TestClearPhp\Model\User;

class RegistrationFormProcessor
{
    protected array $errors = [];

    public function __construct(
        protected UserManager $userManager
    ) {}

    /**
     * @throws ValidationException
     */
    public function process(Request $request): User
    {
        $this->validateEmail($email = $request->get('email', ''));
        $this->validateFirstName($firstName = $request->get('first_name', ''));
        $this->validateLastName($lastName = $request->get('last_name', ''));
        $this->validatePlainPassword(
            $password = $request->get('plain_password', ''),
            $request->get('plain_password2', '')
        );
        $this->validatePhone($phone = $request->get('phone'));

        if (!empty($this->errors)) {
            throw new ValidationException($this->errors);
        }

        $user = (new User())
            ->setEmail($email)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setPassword($password)
            ->setPhone($phone);

        return $this->userManager->createUser($user);
    }

    protected function validateEmail(?string $value): void
    {
        if (empty($value)) {
            $this->errors['email'] = 'Email is required';
        } elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Invalid email format';
        } elseif ($this->userManager->loadUser($value)) {
            $this->errors['email'] = 'User with such email already exists';
        }
    }

    protected function validateFirstName(?string $value): void
    {
        if (empty($value)) {
            $this->errors['first name'] = 'First name is required';
        }
    }

    protected function validateLastName(?string $value): void
    {
        if (empty($value)) {
            $this->errors['last name'] = 'Last name is required';
        }
    }

    protected function validatePlainPassword(?string $value, string $value2): void
    {
        if (empty($value)) {
            $this->errors['password'] = 'Password is required';
        } elseif (strlen($value) < 6) {
            $this->errors['password'] = 'Password should be at least 6 characters long';
        } elseif ($value !== $value2) {
            $this->errors['password'] = 'Passwords do not match';
        }
    }

    protected function validatePhone(?string $value): void
    {
        // can be added here validation for phone number
    }
}
