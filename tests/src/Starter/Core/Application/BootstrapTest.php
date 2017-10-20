<?php

namespace Starter\Core\Application;

use Silex\Application;
use Silex\WebTestCase;

class BootstrapTest extends WebTestCase
{
    public function createApplication()
    {
        $bootstrap = new Bootstrap();
        return $bootstrap->getApplication();
    }

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
