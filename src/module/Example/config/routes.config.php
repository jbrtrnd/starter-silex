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
        ]
    ]
];
