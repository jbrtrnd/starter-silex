<?php
/**
 * Application constants definitions
 *
 * Define the global constants used in the core application, don't put your own constants here.
 *
 * @author Jules Bertrand <jules.brtrnd@gmail.com>
 */

// Application environment
define('APP_ENV', getenv('APP_ENV'));

// Directory containing Composer vendors and autoload
define('DIR_VENDORS', '../vendor');

// Directory containing application modules
define('DIR_MODULES', 'module');

// Directory containing the gloabal configuration
define('DIR_CONFIG', 'config');
