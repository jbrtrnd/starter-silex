<?php

class BootstrapTestCase extends \Silex\WebTestCase
{
    public function createApplication()
    {
        $bootstrap = new \Starter\Core\Application\Bootstrap();
        return $bootstrap->getApplication();
    }
}
