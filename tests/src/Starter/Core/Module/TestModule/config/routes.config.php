<?php

namespace TestModule;

return [
    'controllers' => [
        'test.controller.test' => new Controller\TestController()
    ],
    'routes' => [
        '/test_module_loaded' => [
            'GET,POST' => [
                'controller' => 'test.controller.test',
                'action'     => 'index'
            ]
        ]
    ]
];
