<?php

namespace Starter\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Test\TestModuleTestCase;

/**
 * Class ServiceProviderTest
 *
 * @package Starter\Doctrine
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ServiceProviderTest extends TestModuleTestCase
{
    /**
     * Test if the Doctrine DBAL connection is registered.
     */
    public function testDBALRegistered()
    {
        $configuration = $this->app['starter.configuration'];
        if (isset($configuration['doctrine']['dbal'])) {
            $this->assertInstanceOf(Connection::class, $this->app['db']);
        }
    }

    /**
     * Test if the Doctrine Entity manager is registered.
     */
    public function testEntityManagerRegistered()
    {
        $configuration = $this->app['starter.configuration'];
        if (isset($configuration['doctrine']['dbal'])) {
            $this->assertInstanceOf(EntityManager::class, $this->app['orm.em']);
        }
    }
}
