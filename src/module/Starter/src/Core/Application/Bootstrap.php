<?php

namespace Starter\Core\Application;

use Silex\Application;
use Starter\Core\Module\Loader\ServiceProvider as ModuleLoaderServiceProvider;

/**
 * Wrapper around a Silex application.
 *
 * @package Starter\Core\Application
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Bootstrap
{
    /**
     * @var Application The Silex application.
     */
    protected $application;

    /**
     * Bootstrap constructor.
     *
     * Will create the Silex application and register the required services.
     */
    public function __construct()
    {
        $this->application = new Application();

        $this->application->register(new ModuleLoaderServiceProvider());
    }

    /**
     * Return the Silex application.
     *
     * @return Application The Silex application.
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * Launch the Silex application.
     *
     * When calling this function, the application is able to process HTTP requests.
     *
     * @return void
     */
    public function run(): void
    {
        $this->application->run();
    }
}
