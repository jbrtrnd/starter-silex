<?php
/**
 * Application document root.
 *
 * @author Jules Bertrand <jules.brtrnd@gmail.com>
 */

// Reset the execution directory to project root
chdir(dirname(__DIR__));

// Grab the global constants
require_once 'constants.php';

// Init the autoloader
require_once 'autoload.php';

// Bootstrap the application
$bootstrap = new Starter\Core\Application\Bootstrap();
$bootstrap->run();
