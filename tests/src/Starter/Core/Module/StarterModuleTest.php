<?php

namespace Starter\Core\Module\Loader;

use Starter\Core\Module\StarterModule;
use Test\BootstrapTestCase;

/**
 * Class StarterModuleTest
 *
 * @package Starter\Core\Module
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class StarterModuleTest extends BootstrapTestCase
{
    /**
     * Test if the $loaded property of the module is initialized to false and is true after calling the load method
     */
    public function testLoadedState()
    {
        $module = new StarterModule($this->app);
        $this->assertFalse($module->isLoaded());
        $module->load();
        $this->assertTrue($module->isLoaded());
    }
}
