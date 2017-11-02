<?php

namespace Starter\Core\Module\Loader;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Module loader service provider.
 *
 * Launch the Module loader.
 *
 * @package Starter\Core\Module\Loader
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * Register the module loader service.
     *
     * The module loader will be available at the "starter.module.loader" key.
     *
     * @param Container $application The Silex container.
     *
     * @return void
     */
    public function register(Container $application): void
    {
        $loader = new Service($application);
        $loader->load();

        $application['starter.module.loader'] = $loader;
    }
}
