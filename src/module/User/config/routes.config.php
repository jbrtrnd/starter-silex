<?php
/**
 * Routes for the User module.
 *
 * @author Jules Bertrand <jules.brtrnd@gmail.com>
 */

namespace User;

use Silex\Application;
use User\Security\Middleware\Authentication\AuthenticatedMiddleware;

return [
    'controllers' => [
        'user.controller.user' => function (Application $application) {
            return new Controller\UserController($application);
        },
        'user.controller.authentication' => function (Application $application) {
            return new Controller\AuthenticationController($application);
        },
    ],
    'routes' => [
        '/user' => [
            'GET' => [
                'controller' => 'user.controller.user',
                'action'     => 'search',
                'before'     => [
                    AuthenticatedMiddleware::class
                ]
            ],
            'POST' => [
                'controller' => 'user.controller.user',
                'action'     => 'create',
                'before'     => [
                    AuthenticatedMiddleware::class
                ]
            ],
        ],
        '/user/{id}' => [
            'GET' => [
                'controller' => 'user.controller.user',
                'action'     => 'get',
                'before'     => [
                    AuthenticatedMiddleware::class
                ]
            ],
            'PUT' => [
                'controller' => 'user.controller.user',
                'action'     => 'update',
                'before'     => [
                    AuthenticatedMiddleware::class
                ]
            ],
            'DELETE' => [
                'controller' => 'user.controller.user',
                'action'     => 'remove',
                'before'     => [
                    AuthenticatedMiddleware::class
                ]
            ],
        ],
        '/user/auth/authenticate' => [
            'GET' => [
                'controller' => 'user.controller.authentication',
                'action'     => 'authenticate'
            ]
        ],
        '/user/auth/validate' => [
            'GET' => [
                'controller' => 'user.controller.authentication',
                'action'     => 'validate'
            ]
        ]
    ]
];
