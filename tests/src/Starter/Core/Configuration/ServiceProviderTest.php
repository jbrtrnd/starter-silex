<?php

namespace Starter\Core\Configuration;

use Test\BootstrapTestCase;

/**
 * Class ServiceProviderTest
 *
 * @package Starter\Core\Configuration
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ServiceProviderTest extends BootstrapTestCase
{
    /**
     * @var string Key of the configuration
     */
    protected $key = 'starter.configuration';

    /**
     * Test if the Configuration service provider correctly register the configuration object
     */
    public function testServiceRegistered()
    {
        $this->assertArrayHasKey($this->key, $this->app);
        $this->assertInstanceOf(Configuration::class, $this->app[$this->key]);
    }

    /**
     * Test if the Configuration service provider correctly register the configuration object
     */
    public function testServiceRegisteredHasKey()
    {
        $configuration = $this->app[$this->key];

        $this->assertTrue($configuration->offsetExists('test'));
        $this->assertTrue($configuration['test']);
    }
}
