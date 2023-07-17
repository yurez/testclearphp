<?php

namespace TestClearPhp\Security;

use TestClearPhp\Exception\AuthenticationException;
use TestClearPhp\Model\User;
use TestClearPhp\Service\UserManager;

class SecurityService
{
    public function __construct(
        protected UserManager $userManager
    ) {}

    /**
     * @throws AuthenticationException
     */
    public function authenticate(string $username, string $password): User
    {
        if (!$user = $this->userManager->loadUser($username)) {
            throw new AuthenticationException('User not found');
        }

        if (!$this->verifyPassword($user, $password)) {
            throw new AuthenticationException('Password is invalid');
        }

        $this->setUserInSession($user);

        return $user;
    }

    public function getUserFromSession(): ?User
    {
        return $this->userManager->loadUser($_SESSION['user_email'] ?? '');
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_email']);
    }

    public function removeUserFromSession(): void
    {
        unset($_SESSION['user_email']);
    }

    protected function verifyPassword(User $user, string $password): bool
    {
        return password_verify($password, $user->getPassword());
    }

    protected function setUserInSession(User $user): void
    {
        $_SESSION['user_email'] = $user->getEmail();
    }

}
