<?php

namespace Starter\Core\Configuration;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Global configuration service provider.
 *
 * Load and retrieve the global configuration then inject it in the Silex container.
 *
 * @package Starter\Core\Configuration
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * Load and retrieve the global configuration then inject it in the Silex container.
     *
     * The global configuration will be available at the "starter.configuration" key.
     *
     * @param Container $application The Silex container.
     *
     * @return void
     */
    public function register(Container $application): void
    {
        $global = Factory::fromDirectory(DIR_CONFIG);
        $local = Factory::fromDirectory(DIR_CONFIG . '/local');
        $global->merge($local);

        $application['starter.configuration'] = $global;
    }
}
