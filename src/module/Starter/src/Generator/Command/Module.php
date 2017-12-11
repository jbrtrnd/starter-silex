<?php

namespace Starter\Generator\Command;

use Starter\Generator\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generates modules.
 *
 * @package Starter\Generator\Command
 * @author  Enzo Cornand <goulaheau@gmail.com>
 */
class Module extends Command
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('starter:generate:module')
             ->setDescription('Generate a module')
             ->addArgument('module', InputArgument::REQUIRED, 'The name of the module.');
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
        $module = ucfirst($input->getArgument('module'));

        $moduleFile     = new File\Module($module);
        $moduleTestFile = new File\Test\Module($module);
        $routeFile      = new File\Route($module);

        $moduleFile->create();
        $moduleTestFile->create();
        $routeFile->create();
    }
}
