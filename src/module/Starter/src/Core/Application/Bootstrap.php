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
     * @var Application The Silex application
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
     * Return the Silex application
     *
     * @return Application The Silex application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * Launch the Silex application
     *
     * When calling this function, the application is able to process HTTP requests.
     */
    public function run(): void
    {
        $this->application->run();
    }
}
