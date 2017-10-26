<?php

namespace Starter\Core\Application;

use Silex\Application;
use Test\BootstrapTestCase;

/**
 * Class BootstrapTest
 *
 * @package Starter\Core\Application
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class BootstrapTest extends BootstrapTestCase
{
    /**
     * Test if the Bootstrap instance creates a Silex application
     */
    public function testSilexApplicationCreated()
    {
        $this->assertInstanceOf(Application::class, $this->app);
    }

    /**
     * Test if the Bootstrap instance creates a Silex application
     */
    public function testSilexApplicationLaunched()
    {
        $client  = $this->createClient();
        $client->request('GET', '/');

        $this->assertTrue(!$client->getResponse()->isInvalid());
    }
}
