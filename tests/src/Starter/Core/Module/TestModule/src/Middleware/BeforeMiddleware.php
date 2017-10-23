<?php

namespace TestModule\Middleware;

use Starter\Core\Module\StarterMiddleware;
use Symfony\Component\HttpFoundation\Response;

class BeforeMiddleware extends StarterMiddleware
{
    public function call(): ?Response
    {
        $this->request->request->set('before', true);
        return null;
    }
}
