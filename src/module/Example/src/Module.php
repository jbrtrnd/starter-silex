<?php

namespace Example;

use Starter\Core\Module\StarterModule;

/**
 * Module class for the Example module.
 *
 * @package Example
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Module extends StarterModule
{
    protected function afterLoad(): void
    {
        $this->application['example.something_after_load'] = 'FOO';
    }

    public function afterApplicationLoad(): void
    {
        $this->application['example.something_after_application_load'] = 'BAR';
    }
}
