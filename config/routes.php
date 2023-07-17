<?php
/** @var \TestClearPhp\Core\ServiceLocator $serviceLocator */

return [
    '/' => [new \TestClearPhp\Controller\MainController($serviceLocator), 'index'],
    '/dashboard' => [new \TestClearPhp\Controller\MainController($serviceLocator), 'dashboard'],
    '/register' => [new \TestClearPhp\Controller\MainController($serviceLocator), 'register'],
    '/login' => [new \TestClearPhp\Controller\SecurityController($serviceLocator), 'login'],
    '/logout' => [new \TestClearPhp\Controller\SecurityController($serviceLocator), 'logout'],
];
