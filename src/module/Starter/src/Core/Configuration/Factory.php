<?php

namespace Starter\Core\Configuration;

/**
 * Configuration factory.
 *
 * Creates configuration objects from files and arrays.
 *
 * @package Starter\Core\Configuration
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Factory
{
    /**
     * Create a Configuration object from a PHP array
     *
     * @param array $container The PHP array to parse.
     *
     * @return Configuration The Configuration object created.
     */
    public static function fromArray(array $container): Configuration
    {
        $configuration = new Configuration();

        foreach ($container as $key => $value) {
            $configuration->offsetSet($key, $value);
        }

        return $configuration;
    }

    /**
     * Create a Configuration object from a PHP file.
     *
     * The PHP file must return a PHP array.
     *
     * @param string $path The full path to the PHP file to parse.
     *
     * @return Configuration The Configuration object created.
     */
    public static function fromFile(string $path): Configuration
    {
        $configuration = new Configuration();

        if (file_exists($path)) {
            $container = include $path;
            $configuration = self::fromArray($container);
        }

        return $configuration;
    }

    /**
     * Create a Configuration object from a directory containing PHP files.
     *
     * The PHP files must return a PHP array and they must be named as follows "<myfile>.config.php".
     *
     * @param string $path The full path to the directory.
     *
     * @return Configuration The Configuration object created.
     */
    public static function fromDirectory(string $path): Configuration
    {
        $path = rtrim($path, '/');
        $path = rtrim($path, '\\');

        $configuration = new Configuration();

        foreach (glob($path . '/*.config.php') as $file) {
            $configuration->merge(self::fromFile($file));
        }

        return $configuration;
    }
}
