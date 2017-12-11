<?php

namespace User;

use Test\BootstrapTestCase;

class ModuleTest extends BootstrapTestCase
{
    public function testModuleLoaded()
    {
        $loader = $this->app['starter.module.loader'];
        $modules = $loader->getModules();

        $this->assertArrayHasKey('User', $modules);
    }
}
