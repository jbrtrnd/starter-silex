<?php

namespace TestModule\Middleware;

use Starter\Core\Module\StarterMiddleware;
use Symfony\Component\HttpFoundation\Response;

class AfterMiddleware extends StarterMiddleware
{
    public function call(): ?Response
    {
        $this->request->request->set('after', true);
        return null;
    }
}
