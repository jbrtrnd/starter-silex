<?php
/**
 * Application constants definitions.
 *
 * Define the global constants used in the core application, don't put your own constants here.
 *
 * @author Jules Bertrand <jules.brtrnd@gmail.com>
 */

// Application environment
define('APP_ENV', getenv('APP_ENV'));

// Application version
define('VERSION', '1.2.2');

// Directory containing Composer vendors and autoload
define('DIR_VENDORS', '../vendor');

// Directory containing application modules
define('DIR_MODULES', 'module');

// Directory containing the global configuration
define('DIR_CONFIG', 'config');

// Directory containing application data
define('DIR_DATA', 'data');

// Directory application tests
define('DIR_TESTS', '../tests/src');
