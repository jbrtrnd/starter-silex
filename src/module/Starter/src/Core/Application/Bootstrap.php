<?php

namespace Starter\Core\Application;

use Silex\Application;

/**
 * Wrapper around a Silex application
 *
 * @package Starter\Core\Application
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Bootstrap
{
    /**
     * @var Application
     */
    protected $application;

    /**
     * Bootstrap constructor
     *
     * Will create the Silex application without launching it.
     */
    public function __construct()
    {
        $this->application = new Application();
    }

    /**
     * @return Application the Silex application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * Launch the Silex application
     *
     * From now, the application is able to process HTTP requests.
     */
    public function run(): void
    {
        $this->application->run();
    }
}
