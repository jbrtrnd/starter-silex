<?php

namespace Example\Middleware;

use Starter\Core\Module\StarterMiddleware;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dump the HTTP method before processing the request.
 *
 * @package Example\Middleware
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ExampleMiddleware extends StarterMiddleware
{
    public function call(): ?Response
    {
        var_dump($this->request->getMethod());
        return null;
    }
}
