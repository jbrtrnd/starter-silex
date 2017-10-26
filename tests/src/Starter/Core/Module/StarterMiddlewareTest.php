<?php

namespace Starter\Core\Module;

use Test\TestModuleTestCase;

/**
 * Class StarterMiddlewareTest
 *
 * @package Starter\Core\Module
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class StarterMiddlewareTest extends TestModuleTestCase
{
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
