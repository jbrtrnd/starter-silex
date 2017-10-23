<?php

namespace Starter\Core\Module\Loader;

use Test\BootstrapTestCase;

/**
 * Class ServiceTest
 *
 * @package Starter\Core\Module\Loader
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ServiceTest extends BootstrapTestCase
{
    /**
     * Test if the module loader retrieve all the modules of the module directory
     */
    public function testModulesRetrieved()
    {
        $loader = new Service($this->app);

        $modules = [];
        foreach (scandir(DIR_MODULES) as $module) {
            $path = DIR_MODULES . '/' . $module;
            if (is_dir($path) && $module !== '.' && $module !== '..') {
                $className = $module . '\Module';
                if (class_exists($className)) {
                    $modules[$module] = new $className($this->app);
                }
            }
        }

        $this->assertEquals($modules, $loader->getModules());
    }

    /**
     * Test if the $loaded property of the module loader is initialized to false and is true after calling the load method
     */
    public function testLoadedState()
    {
        $loader = new Service($this->app);

        $this->assertFalse($loader->isLoaded());
        $loader->load();
        $this->assertTrue($loader->isLoaded());
    }

    /**
     * Test if the $loaded properties of all the modules are initialized to false and are true after calling the load method
     */
    public function testAllModulesLoadedState()
    {
        $loader  = new Service($this->app);
        $modules = $loader->getModules();

        foreach ($modules as $module) {
            $this->assertFalse($module->isLoaded());
        }
        $loader->load();
        foreach ($modules as $module) {
            $this->assertTrue($module->isLoaded());
        }
    }
}
