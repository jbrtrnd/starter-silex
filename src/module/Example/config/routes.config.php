<?php
/**
 * Routes for the Example module.
 *
 * @author Jules Bertrand <jules.brtrnd@gmail.com>
 */

namespace Example;

use Example\Middleware\ExampleMiddleware;
use Silex\Application;

return [
    'controllers' => [
        'example.controller.example' => function (Application $application) {
            return new Controller\ExampleController($application);
        },
        'example.controller.bar' => function (Application $application) {
            return new Controller\BarController($application);
        },
    ],
    'routes' => [
        '/example' => [
            'GET' => [
                'controller' => 'example.controller.example',
                'action'     => 'html',
                'before'     => [
                    ExampleMiddleware::class
                ]
            ],
            'POST,PUT' => [
                'controller' => 'example.controller.example',
                'action'     => 'json',
                'before'     => [
                    ExampleMiddleware::class
                ]
            ],
        ],
        '/bar' => [
            'GET' => [
                'controller' => 'example.controller.bar',
                'action'     => 'search'
            ],
            'POST' => [
                'controller' => 'example.controller.bar',
                'action'     => 'create'
            ],
        ],
        '/bar/{id}' => [
            'GET' => [
                'controller' => 'example.controller.bar',
                'action'     => 'get'
            ],
            'PUT' => [
                'controller' => 'example.controller.bar',
                'action'     => 'update'
            ],
            'DELETE' => [
                'controller' => 'example.controller.bar',
                'action'     => 'delete'
            ],
        ],
    ]
];
