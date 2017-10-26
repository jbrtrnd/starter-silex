<?php

namespace TestModule;

use Starter\Core\Module\StarterModule;
use Symfony\Component\Console\Application as Console;
use TestModule\Command\TestCommand;

class Module extends StarterModule
{
    protected function afterLoad(): void
    {
        $this->application['something_after_load'] = 'test';
    }

    public function afterApplicationLoad(): void
    {
        $this->application['something_after_application_load'] = 'test';
    }

    public function afterConsoleLoad(Console $console): void
    {
        $console->add(new TestCommand());
    }
}
