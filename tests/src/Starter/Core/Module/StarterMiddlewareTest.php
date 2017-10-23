<?php

namespace Starter\Core\Module;

use Starter\Core\Module\Loader\Service;
use Test\BootstrapTestCase;
use TestModule\Controller\TestController;
use TestModule\Module;

/**
 * Class StarterMiddlewareTest
 *
 * @package Starter\Core\Module
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class StarterMiddlewareTest extends BootstrapTestCase
{
    public function createApplication()
    {
        $application = parent::createApplication();

        $loader  = new Service($application);
        $modules = $loader->getModules();
        $modules['TestModule'] = new Module($application);
        $loader->setModules($modules);

        $loader->load();

        return $application;
    }

    /**
     * Test if the before middleware are loaded.
     */
    public function testTestModuleBeforeMiddlewareLoaded()
    {
        $client  = $this->createClient();
        $client->request('GET', '/test_module_loaded');
        $request = $client->getRequest();

        $this->assertTrue($request->request->get('before'));
    }

    /**
     *  Test if the after middleware are loaded.
     */
    public function testTestModuleAfterMiddlewareLoaded()
    {
        $client  = $this->createClient();
        $client->request('GET', '/test_module_loaded');
        $request = $client->getRequest();

        $this->assertTrue($request->request->get('after'));
    }
}
