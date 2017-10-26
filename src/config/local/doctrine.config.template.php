<?php
/**
 * Application local doctrine configuration template file.
 *
 * Copy this file for "doctrine.config.php" and fill your values.
 * See Doctrine DBAL configuration documentation
 * {@link http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html}.
 *
 * @author Jules Bertrand <jules.brtrnd@gmail.com>
 */

return [
    'doctrine' => [
        'dbal' => [
            'default' => [
                'driver'   => 'pdo_mysql',
                'host'     => 'localhost',
                'dbname'   => 'my_database',
                'user'     => 'my_user',
                'password' => 'my_password',
                'driverOptions' => [
                    1002 => 'SET NAMES utf8'
                ]
            ]
        ]
    ]
];
