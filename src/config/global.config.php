<?php
/**
 * Application global configuration file.
 *
 * All the PHP files ending by "*.config.php" will be loaded in the global application configuration.
 * Your local config files should be in the "local" directory and don't be processed by your version control system.
 *
 * @author Jules Bertrand <jules.brtrnd@gmail.com>
 */

return [
    // Entry for testing purpose, please do not delete it
    'test' => true,
    // Default configuration to manage global HTTP responses
    'http' => [
        'response' => [
            // Add custom headers you want to be added in all your HTTP responses
            'headers' => [
                'Access-Control-Allow-Origin'  => '*',
                'Access-Control-Allow-Headers' => 'Content-Type',
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS'
            ]
        ]
    ]
];
