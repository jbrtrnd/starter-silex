<?php

// Reset the execution directory to application root
chdir(dirname(__DIR__ . '/../src/public'));

// Grab the global constants
require_once 'constants.php';

// Init the autoloader
$loader = require_once 'autoload.php';
$loader->addPsr4('Test\\', __DIR__ . '/utils');


if (!class_exists('\PHPUnit\Framework\TestCase', true)) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
} elseif (!class_exists('\PHPUnit_Framework_TestCase', true)) {
    class_alias('\PHPUnit\Framework\TestCase', '\PHPUnit_Framework_TestCase');
}
