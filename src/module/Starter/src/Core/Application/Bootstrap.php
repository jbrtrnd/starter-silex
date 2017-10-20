<?php

namespace Starter\Core\Application;

use Silex\Application;

/**
 * Class Bootstrap
 *
 * @package Starter\Core\Application
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Bootstrap
{
    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {
        $application = new Application();
        $application->run();
    }
}
