<?php

// Reset the execution directory to application root
chdir(dirname(__DIR__));

// Grab the global constants
require_once 'constants.php';

// Init the autoloader
require_once 'autoload.php';

if (!class_exists('\PHPUnit\Framework\TestCase', true)) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
} elseif (!class_exists('\PHPUnit_Framework_TestCase', true)) {
    class_alias('\PHPUnit\Framework\TestCase', '\PHPUnit_Framework_TestCase');
}