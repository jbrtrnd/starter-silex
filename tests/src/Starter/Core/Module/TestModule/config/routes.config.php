<?php

namespace TestModule;

use TestModule\Middleware\AfterMiddleware;
use TestModule\Middleware\BeforeMiddleware;

return [
    'controllers' => [
        'test.controller.test' => new Controller\TestController()
    ],
    'routes' => [
        '/test_module_loaded' => [
            'GET,POST' => [
                'controller' => 'test.controller.test',
                'action'     => 'index',
                'before'     => [
                    BeforeMiddleware::class
                ],
                'after'      => [
                    AfterMiddleware::class
                ]
            ]
        ]
    ]
];
