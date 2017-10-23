<?php

namespace Starter;

use Silex\Provider\ServiceControllerServiceProvider;
use Starter\Core\Module\StarterModule;

/**
 * Module class for the Starter module.
 *
 * @package Starter
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Module extends StarterModule
{
    /**
     * Register the Starter services in the Silex container.
     *
     * @return void
     */
    protected function afterLoad(): void
    {
        $this->application['debug'] = true;

        /**
         * Register the ServiceControllerServiceProvider
         * @see http://silex.sensiolabs.org/doc/2.0/providers/service_controller.html
         */
        $this->application->register(new ServiceControllerServiceProvider());
    }
}
