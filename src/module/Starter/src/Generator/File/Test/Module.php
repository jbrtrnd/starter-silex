<?php

namespace Starter\Generator\File\Test;

use Starter\Generator\File;

/**
 * Generate a module test class file.
 *
 * @package Starter\Generator\File\Test
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
        if (!is_dir(DIR_TESTS . '/' . $this->module)) {
            mkdir(DIR_TESTS . '/' . $this->module);
        } else {
            throw new \RuntimeException(
                'Error while creating ' . DIR_TESTS . '/' . $this->module . ' : Directory already exists.'
            );
        }

        if (!is_dir(DIR_TESTS . '/' . $this->module)) {
            mkdir(DIR_TESTS . '/' . $this->module);
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
        return DIR_TESTS . '/' . $this->module . '/ModuleTest.php';
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

use Test\BootstrapTestCase;

class ModuleTest extends BootstrapTestCase
{
    public function testModuleLoaded()
    {
        \$loader = \$this->app['starter.module.loader'];
        \$modules = \$loader->getModules();

        \$this->assertArrayHasKey('$this->module', \$modules);
    }
}

EOT;
    }
}
