<?php

namespace TestModule\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TestController
{
    public function index()
    {
        return new JsonResponse([
            'ok' => true
        ]);
    }

    public function json(Request $request)
    {
        return new JsonResponse($request->request->all());
    }
}