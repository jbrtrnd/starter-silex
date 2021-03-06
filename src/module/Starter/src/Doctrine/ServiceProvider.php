<?php

namespace Starter\Doctrine;

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\DoctrineServiceProvider;

/**
 * Loads Doctrine DBAL and ORM in the Silex application.
 *
 * Using DoctrineServiceProvider and DoctrineOrmServiceProvider from dflydev/doctrine-orm-service-provider .
 *
 * @package Starter\Doctrine
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * Loads Doctrine DBAL and ORM in the Silex application.
     *
     * @param Container $application The Silex container.
     *
     * @return void
     */
    public function register(Container $application): void
    {
        $configuration = $application['starter.configuration'];

        if (isset($configuration['doctrine']['dbal']) && !isset($application['dbs'])) {
            $application->register(new DoctrineServiceProvider(), [
                'dbs.options' => $configuration['doctrine']['dbal']
            ]);

            $application->register(new DoctrineOrmServiceProvider(), [
                'orm.proxies_dir' => DIR_DATA . '/proxies',
                'orm.em.options' => [
                    'mappings' => []
                ]
            ]);
        }
    }
}
