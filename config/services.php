<?php
/** @var \TestClearPhp\Core\ServiceLocator $serviceLocator */

$serviceLocator->addService(
    \TestClearPhp\Database\Database::class,
    new \TestClearPhp\Database\Database($_ENV['MYSQL_HOST'], $_ENV['MYSQL_DATABASE'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'])
);

$serviceLocator->addService(
    \TestClearPhp\Database\UserDataMapper::class,
    new \TestClearPhp\Database\UserDataMapper()
);

$serviceLocator->addService(
    \TestClearPhp\Model\UserRepository::class,
    new \TestClearPhp\Model\UserRepository(
        $serviceLocator->getService(\TestClearPhp\Database\Database::class),
        $serviceLocator->getService(\TestClearPhp\Database\UserDataMapper::class)
    )
);

$serviceLocator->addService(
    \TestClearPhp\Service\UserManager::class,
    new \TestClearPhp\Service\UserManager(
        $serviceLocator->getService(\TestClearPhp\Model\UserRepository::class)
    )
);

$serviceLocator->addService(
    \TestClearPhp\Service\RegistrationFormProcessor::class,
    new \TestClearPhp\Service\RegistrationFormProcessor(
        $serviceLocator->getService(\TestClearPhp\Service\UserManager::class)
    )
);

$serviceLocator->addService(
    \TestClearPhp\Security\SecurityService::class,
    new \TestClearPhp\Security\SecurityService(
        $serviceLocator->getService(\TestClearPhp\Service\UserManager::class)
    )
);

return $serviceLocator;