<?php

use TestClearPhp\Core\Kernel;
use TestClearPhp\Core\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = new Kernel();

$kernel->handleRequest(Request::createFromGlobals());
