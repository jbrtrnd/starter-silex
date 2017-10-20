<?php

namespace Starter\Core\Module\Loader;

use Test\BootstrapTestCase;

/**
 * Class ServiceProviderTest
 *
 * @package Starter\Core\Module\Loader
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ServiceProviderTest extends BootstrapTestCase
{
    /**
     * @var string Key of the module loader service
     */
    protected $key = 'starter.module.loader';

    /**
     * Test if the Module loader service provider correctly register the Module loader service
     */
    public function testServiceRegistered()
    {
        $this->assertArrayHasKey($this->key, $this->app);
        $this->assertInstanceOf(Service::class, $this->app[$this->key]);
    }

    /**
     * Test if the Module loader service provider correctly launch the Module loader service
     */
    public function testServiceLaunched()
    {
        $this->assertTrue($this->app[$this->key]->isLoaded());
    }
}
