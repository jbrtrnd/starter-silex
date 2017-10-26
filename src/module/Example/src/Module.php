<?php

namespace Example;

use Example\Command\ExampleCommand;
use Starter\Core\Module\StarterModule;
use Symfony\Component\Console\Application as Console;

/**
 * Module class for the Example module.
 *
 * @package Example
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Module extends StarterModule
{
    /**
     * Do something when this module is loaded.
     *
     * @return void
     */
    protected function afterLoad(): void
    {
        /**
         * $this->application['example.something_after_load'] = 'FOO';
         * $this->application->register(new Silex\Provider\VarDumperServiceProvider());
         */
    }

    /**
     * Do something when all modules are loaded.
     *
     * @return void
     */
    public function afterApplicationLoad(): void
    {
        /**
         * $app['swiftmailer.options'] = array(
         *     'host' => 'host',
         *     'port' => '25',
         *     'username' => 'username',
         *     'password' => 'password',
         *     'encryption' => null,
         *     'auth_mode' => null
         * );
         * $this->application->register(new Silex\Provider\SwiftmailerServiceProvider());
         */
    }

    /**
     * Add commands
     *
     * @param Console $console The console application.
     * @return void
     */
    public function afterConsoleLoad(Console $console): void
    {
        $console->add(new ExampleCommand());
    }
}
