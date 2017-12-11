<?php

namespace User;

use Starter\Core\Module\StarterModule;
use User\Security\Token\ServiceProvider as TokenServiceProvider;

/**
 * Module class for the User module.
 *
 * @package User
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
        // Token service provider
        $this->application->register(new TokenServiceProvider());
    }
}
