<?php

namespace TestModule\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('test:command')
             ->setDescription('A test command.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        // Some code
    }
}
