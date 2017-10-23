<?php

namespace Example;

use Starter\Core\Module\StarterModule;

/**
 * Module class for the Example module.
 *
 * @package Example
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Module extends StarterModule
{
    protected function afterLoad(): void
    {
        /**
         * $this->application['example.something_after_load'] = 'FOO';
         * $this->application->register(new Silex\Provider\VarDumperServiceProvider());
         */
    }

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
}
