<?php

namespace Starter\Core\Module;

use Test\TestModuleTestCase;
use TestModule\Controller\TestController;

/**
 * Class StarterModuleTest
 *
 * @package Starter\Core\Module
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class StarterModuleTest extends TestModuleTestCase
{
    /**
     * Test if the loader loads the module controllers.
     */
    public function testTestModuleControllersLoaded()
    {
        $this->assertInstanceOf(TestController::class, $this->app['test.controller.test']);
    }

    /**
     * Test if the afterLoad event is called when loading the TestModule.
     */
    public function testTestModuleAfterLoad()
    {
        $this->assertEquals('test', $this->app['something_after_load']);
    }

    /**
     * Test if the afterApplicationLoad event is called when loading the TestModule.
     */
    public function testTestModuleAfterApplicationLoad()
    {
        $this->assertEquals('test', $this->app['something_after_application_load']);
    }

    /**
     * Test if the loader loads the module routes.
     */
    public function testTestModuleRoutesLoaded()
    {
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
        $client  = $this->createClient();
        $client->request('OPTIONS', '/test_module_loaded');
        $this->assertTrue($client->getResponse()->isOk());
    }
}
