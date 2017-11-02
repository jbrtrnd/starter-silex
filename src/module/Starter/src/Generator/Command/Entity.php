<?php

namespace Starter\Generator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generates entities.
 *
 * @package Starter\Generator\Command
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Entity extends Command
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('starter:generate:entity')
             ->setDescription('Generate an entity')
             ->addArgument('module', InputArgument::REQUIRED, 'The name of the module.')
             ->addArgument('entity', InputArgument::REQUIRED, 'The name of the entity.');
    }

    /**
     * Executes the current command.
     *
     * @param InputInterface  $input  An InputInterface instance.
     * @param OutputInterface $output An OutputInterface instance.
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $module = $input->getArgument('module');
        $entity = $input->getArgument('entity');

        $entityFile     = new \Starter\Generator\File\Entity($entity, $module);
        $repositoryFile = new \Starter\Generator\File\Repository($entity, $module);
        $controllerFile = new \Starter\Generator\File\Controller($entity, $module);

        $entityFile->create();
        $repositoryFile->create();
        $controllerFile->create();
    }
}
