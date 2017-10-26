<?php

namespace Example\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ExampleCommand
 *
 * @package Example\Command
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ExampleCommand extends Command
{
    /**
     * Configure the command
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('example:command')
            ->setDescription('An example command.');
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        // Let's do something
    }
}
