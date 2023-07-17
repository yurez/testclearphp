<?php

namespace TestClearPhp\Service;

use TestClearPhp\Exception\ValidationException;
use TestClearPhp\Model\User;
use TestClearPhp\Model\UserRepository;

class UserManager
{
    public function __construct(
        protected UserRepository $repository
    ) {}

    public function createUser(
        User $user
    ): User
    {
        $this->validateUser($user);

        return $this->updatePassword($user, $user->getPassword());
    }

    public function loadUser(string $username): ?User
    {
        return $this->repository->findByEmail($username);
    }

    public function updatePassword(User $user, string $newPassword): User
    {
        $user->setPassword(
            password_hash($newPassword, PASSWORD_BCRYPT)
        );

        $this->repository->saveUser($user);

        return $user;
    }

    /**
     * @throws ValidationException
     */
    protected function validateUser(User $user): void
    {
        $errors = [];

        if (empty($user->getEmail())) {
            $errors['email'] = 'Email field is required';
        }
        if (empty($user->getPassword())) {
            $errors['password'] = 'Password field is required';
        }
        if (empty($user->getFirstName())) {
            $errors['first_name'] = 'First Name field is required';
        }
        if (empty($user->getLastName())) {
            $errors['last_name'] = 'Last Name field is required';
        }

        $existingUser = $this->repository->findByEmail($user->getEmail());
        if ($existingUser) {
            $errors['email'] = 'A user with this email already exists';
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
    }
}
