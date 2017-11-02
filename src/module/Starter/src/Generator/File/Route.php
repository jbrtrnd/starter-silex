<?php

namespace Starter\Generator\File;

use Starter\Generator\File;

/**
 * Generate a route file.
 *
 * @package Starter\Generator\File
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Route extends File
{
    /**
     * @var string The module name.
     */
    protected $module;

    /**
     * Route constructor.
     *
     * @param string $module Module name.
     */
    public function __construct(string $module)
    {
        $this->module = ucfirst($module);
    }

    /**
     * Create the file.
     *
     * The "config" module dir will be created if don't exist.
     *
     * @throws \RuntimeException When the module directory doesn't exists.
     *
     * @return void
     */
    public function create(): void
    {
        if (!is_dir(DIR_MODULES . '/' . $this->module)) {
            throw new \RuntimeException('Error while creating ' . $this->getFilename() . ' : Module doesn\'t exists.');
        }

        if (!is_dir(DIR_MODULES . '/' . $this->module . '/config')) {
            mkdir(DIR_MODULES . '/' . $this->module . '/config');
        }

        parent::create();
    }


    /**
     * Return the full name of the file (path included).
     *
     * @return string
     */
    public function getFilename(): string
    {
        return DIR_MODULES . '/' . $this->module . '/config/routes.config.php';
    }

    /**
     * Content of a route file.
     *
     * @return string
     */
    public function generate(): string
    {
        return <<<EOT
<?php
/**
 * Routes for the $this->module module.
 */

namespace $this->module;

use Silex\Application;

return [
    'controllers' => [
    ],
    'routes' => [
    ]
];

EOT;
    }
}
