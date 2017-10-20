<?php

namespace Starter\Core\Application;

use Silex\WebTestCase;
use Symfony\Component\Console\Application;

class ConsoleTest extends WebTestCase
{
    public function createApplication()
    {
        $bootstrap = new Console();
        return $bootstrap->getConsole();
    }

    /**
     * Test if the Console instance creates a Symfony console application
     */
    public function testSymfonyConsoleApplicationCreated()
    {
        $this->assertInstanceOf(Application::class, $this->app);
    }
}
