<?php

namespace Starter;

use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Silex\Provider\ServiceControllerServiceProvider;
use Starter\Core\Http\JsonBody\ServiceProvider as JsonBodyServiceProvider;
use Starter\Core\Module\StarterModule;
use Starter\Doctrine\ServiceProvider as DoctrineServiceProvider;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * Module class for the Starter module.
 *
 * @package Starter
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Module extends StarterModule
{
    /**
     * Register the Starter services in the Silex container.
     *
     * @return void
     */
    protected function afterLoad(): void
    {
        $this->application['debug'] = true;

        /**
         * Register the ServiceControllerServiceProvider
         * @see http://silex.sensiolabs.org/doc/2.0/providers/service_controller.html
         */
        $this->application->register(new ServiceControllerServiceProvider());

        // Json Body request parser provider
        $this->application->register(new JsonBodyServiceProvider());

        // Doctrine provider
        $this->application->register(new DoctrineServiceProvider());
    }

    /**
     * Add Starter commands.
     *
     * Doctrine commands needs the "em" helper set.
     *
     * @param Console $console The console application.
     * @return void
     */
    public function afterConsoleLoad(Console $console): void
    {
        $console->setHelperSet(new HelperSet([
            'em' => new EntityManagerHelper($this->application['orm.em'])
        ]));

        $console->addCommands([
            new \Starter\Generator\Command\Module,
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand,
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand,
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand,
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand,
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand,
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand,
            new \Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand,
            new \Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand,
            new \Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand,
            new \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand,
            new \Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand,
            new \Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand,
            new \Doctrine\ORM\Tools\Console\Command\InfoCommand,
            new \Doctrine\ORM\Tools\Console\Command\RunDqlCommand,
            new \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand,
            new \Doctrine\DBAL\Tools\Console\Command\ImportCommand,
            new \Doctrine\DBAL\Tools\Console\Command\ReservedWordsCommand,
            new \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand
        ]);
    }
}
