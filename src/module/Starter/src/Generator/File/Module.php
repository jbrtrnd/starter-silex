<?php

namespace Starter\Generator\File;

use Starter\Generator\File;

/**
 * Generate a module class file.
 *
 * @package Starter\Generator\File
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Module extends File
{
    /**
     * @var string The module name.
     */
    protected $module;

    /**
     * Module constructor.
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
     * The Module dir and Module src dir will be created if don't exist.
     *
     * @throws \RuntimeException When the Module directory already exists.
     *
     * @return void
     */
    public function create(): void
    {
        if (!is_dir(DIR_MODULES . '/' . $this->module)) {
            mkdir(DIR_MODULES . '/' . $this->module);
        } else {
            throw new \RuntimeException(
                'Error while creating ' . DIR_MODULES . '/' . $this->module . ' : Directory already exists.'
            );
        }

        if (!is_dir(DIR_MODULES . '/' . $this->module . '/src')) {
            mkdir(DIR_MODULES . '/' . $this->module . '/src');
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
        return DIR_MODULES . '/' . $this->module . '/src/Module.php';
    }

    /**
     * Content of a module file.
     *
     * @return string
     */
    public function generate(): string
    {
        return <<<EOT
<?php

namespace $this->module;

use Starter\Core\Module\StarterModule;

/**
 * Module class for the $this->module module.
 *
 * @package $this->module
 */
class Module extends StarterModule
{
}

EOT;
    }
}
