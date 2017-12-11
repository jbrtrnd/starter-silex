<?php

namespace User\Security\Token;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use User\Security\Middleware\User\CurrentUserMiddleware;

/**
 * Token service provider.
 *
 * Create the token service.
 *
 * @package User\Security\Token
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
        $module        = $application['starter.module.loader']->getModule('User');
        $configuration = $module->getConfiguration()['security']['token'];

        $application['user.service.security.token'] = new Service(
            $configuration['secret'],
            $configuration['algorithm'],
            $configuration['expiration']
        );

        // Current user middleware
        $application->before(function (Request $request, Application $application) {
            $middleware = new CurrentUserMiddleware($request, null, $application);
            return $middleware->call();
        });
    }
}
