<?php

namespace Starter\Core\Http\JsonBody;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Json body request parser service provider.
 *
 * Affect to the Silex container a global before middleware to parse json request.
 *
 * @package Starter\Core\Http\JsonBody
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * Affect to the Silex container a global before middleware to parse json request.
     *
     * @param Container $application The Silex container.
     *
     * @return void
     */
    public function register(Container $application): void
    {
        $application->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : []);
            }
        });
    }
}
