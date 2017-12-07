<?php
/**
 * Configuration for the User module.
 *
 * @author Jules Bertrand <jules.brtrnd@gmail.com>
 */

namespace User;

return [
    'security' => [
        'token' => [
            'secret'     => 'LYFM5s7GcFbremwk3xdZ8Yx6ZKtqavemEgwBC8PEeSCaWe5cKCr9mUkgrmMFqJ4M',
            'algorithm'  => 'HS256',
            // One week
            'expiration' => 604800
        ]
    ]
];
