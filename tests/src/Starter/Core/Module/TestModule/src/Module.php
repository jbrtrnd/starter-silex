<?php

namespace TestModule;

use Starter\Core\Module\StarterModule;

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
}
