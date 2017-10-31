<?php

namespace Starter\Generator\Command;

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
        $this->setName('generate:module')
             ->setDescription('Generate a module')
             ->addArgument('name', InputArgument::REQUIRED, 'The name of the module.');
    }

    /**
     * Executes the current command.
     *
     * @param InputInterface  $input  An InputInterface instance.
     * @param OutputInterface $output An OutputInterface instance.
     *
     * @throws \RuntimeException When bundle can't be executed.
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $name = ucfirst($input->getArgument('name'));
        $dir  = DIR_MODULES . '/' . $name;

        if (file_exists($dir)) {
            throw new \RuntimeException(sprintf(
                'Unable to generate the module as the target directory "%s" exists.',
                realpath($dir)
            ));
        }

        mkdir($dir);

        mkdir($dir . '/config');
        file_put_contents($dir . '/config/routes.config.php', <<<EOT
<?php
/**
 * Routes for the $name module.
 */

namespace $name;

use Silex\Application;

return [
    
];

EOT
        );

        mkdir($dir . '/src');
        file_put_contents($dir . '/src/Module.php', <<<EOT
<?php

namespace $name;

use Starter\Core\Module\StarterModule;

/**
 * Module class for the $name module.
 *
 * @package $name
 */
class Module extends StarterModule
{
}

EOT
        );
    }
}
