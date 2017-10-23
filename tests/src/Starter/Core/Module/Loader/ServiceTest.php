<?php

namespace Starter\Core\Module\Loader;

use Test\BootstrapTestCase;
use TestModule\Controller\TestController;
use TestModule\Module;

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

    /**
     * Loads the TestModule in the application.
     */
    protected function loadTestModule()
    {
        $loader  = new Service($this->app);
        $modules = $loader->getModules();
        $modules['TestModule'] = new Module($this->app);
        $loader->setModules($modules);

        $loader->load();
    }

    /**
     * Test if the loader loads the module controllers.
     */
    public function testTestModuleControllersLoaded()
    {
        $this->loadTestModule();
        $this->assertInstanceOf(TestController::class, $this->app['test.controller.test']);
    }

    /**
     * Test if the afterLoad event is called when loading the TestModule.
     */
    public function testTestModuleAfterLoad()
    {
        $this->loadTestModule();
        $this->assertEquals('test', $this->app['something_after_load']);
    }

    /**
     * Test if the afterApplicationLoad event is called when loading the TestModule.
     */
    public function testTestModuleAfterApplicationLoad()
    {
        $this->loadTestModule();
        $this->assertEquals('test', $this->app['something_after_application_load']);
    }

    /**
     * Test if the loader loads the module routes.
     */
    public function testTestModuleRoutesLoaded()
    {
        $this->loadTestModule();

        $client  = $this->createClient();
        $client->request('POST', '/test_module_loaded');
        $this->assertTrue($client->getResponse()->isOk());

        $client  = $this->createClient();
        $client->request('GET', '/test_module_loaded');
        $this->assertTrue($client->getResponse()->isOk());
    }

    /**
     * Test if the loader loads the module routes and adds automatic OPTIONS method.
     */
    public function testTestModuleRoutesOptionsLoaded()
    {
        $this->loadTestModule();

        $client  = $this->createClient();
        $client->request('OPTIONS', '/test_module_loaded');
        $this->assertTrue($client->getResponse()->isOk());
    }
}
