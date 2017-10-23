<?php

namespace Starter\Core\Module;

use Pimple\Container;

/**
 * The starter module base class.
 *
 * Every custom module must have a Module class definition in their src directory.
 *
 * @package Starter\Core\Module
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class StarterModule
{
    /**
     * @var Container The Silex container.
     */
    protected $application;

    /**
     * @var bool Indicate if the module is loaded.
     */
    protected $loaded;

    /**
     * StarterModule constructor.
     *
     * @param Container $application The Silex container.
     */
    public function __construct(Container $application)
    {
        $this->application = $application;
        $this->loaded      = false;
    }

    /**
     * Load the current module in the Silex container.
     *
     * @return void
     */
    public function load(): void
    {
        if (!$this->loaded) {
            $this->loaded = true;
        }
    }

    /**
     * Return true if the module is loaded.
     *
     * @return bool The loaded state.
     */
    public function isLoaded(): bool
    {
        return $this->loaded;
    }
}
