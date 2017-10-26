<?php

namespace Test;

/**
 * Class BootstrapTestCase
 *
 * @package Test
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class BootstrapTestCase extends \Silex\WebTestCase
{
    public function createApplication()
    {
        $bootstrap = new \Starter\Core\Application\Bootstrap();
        return $bootstrap->getApplication();
    }
}
