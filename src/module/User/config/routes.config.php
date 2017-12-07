<?php
/**
 * Routes for the User module.
 *
 * @author Jules Bertrand <jules.brtrnd@gmail.com>
 */

namespace User;

use Silex\Application;

return [
    'controllers' => [
        'user.controller.user' => function (Application $application) {
            return new Controller\UserController($application);
        },
    ],
    'routes' => [
        '/user/user' => [
            'GET' => [
                'controller' => 'user.controller.user',
                'action'     => 'search'
            ],
            'POST' => [
                'controller' => 'user.controller.user',
                'action'     => 'create'
            ],
        ],
        '/user/user/{id}' => [
            'GET' => [
                'controller' => 'user.controller.user',
                'action'     => 'get'
            ],
            'PUT' => [
                'controller' => 'user.controller.user',
                'action'     => 'update'
            ],
            'DELETE' => [
                'controller' => 'user.controller.user',
                'action'     => 'remove'
            ],
        ],
    ]
];
