<?php

namespace Test;

use Starter\Core\Module\Loader\Service;
use TestModule\Module;

/**
 * Class TestModuleTestCase
 *
 * @package Test
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class TestModuleTestCase extends BootstrapTestCase
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
}
