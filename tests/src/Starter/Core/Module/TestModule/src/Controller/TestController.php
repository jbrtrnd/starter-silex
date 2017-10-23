<?php

namespace TestModule\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class TestController
{
    public function index()
    {
        return new JsonResponse([
            'ok' => true
        ]);
    }
}