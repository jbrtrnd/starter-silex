<?php

namespace Starter\Core\Module\Loader;

use Pimple\Container;
use Starter\Core\Module\Loader\Exception\ModuleClassNotFoundException;
use Starter\Core\Module\StarterModule;

/**
 * Module loader service.
 *
 * Autoload modules in the Silex application.
 *
 * @package Starter\Core\Module\Loader
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Service
{
    /**
     * @var Container The Silex container.
     */
    protected $application;

    /**
     * @var bool Indicate if the service has loaded all the modules.
     */
    protected $loaded;

    /**
     * @var StarterModule[] List of modules.
     */
    protected $modules;

    /**
     * Service constructor.
     *
     * @param Container $application The Silex container.
     */
    public function __construct(Container $application)
    {
        $this->application = $application;
        $this->loaded      = false;

        $this->browseModules();
    }

    /**
     * Load all the modules.
     *
     * @return void
     */
    public function load(): void
    {
        foreach ($this->modules as $module) {
            $module->load();
        }

        $this->loaded = true;
    }

    /**
     * Browse the modules to load.
     *
     * The modules are set in the $modules property with their name as key and the Module class instance as value.
     *
     * @return void
     * @throws ModuleClassNotFoundException If the Module class doesn't exist in the module src directory.
     */
    protected function browseModules(): void
    {
        foreach (scandir(DIR_MODULES) as $module) {
            $path = DIR_MODULES . '/' . $module;
            if (is_dir($path) && $module !== '.' && $module !== '..') {
                $className = $module . '\Module';
                if (!class_exists($className)) {
                    throw new ModuleClassNotFoundException($module);
                }

                $this->modules[$module] = new $className($this->application);
            }
        }
    }

    /**
     * Return true if the service has loaded all the modules.
     *
     * @return bool The loaded state.
     */
    public function isLoaded(): bool
    {
        return $this->loaded;
    }

    /**
     * Return the browsed modules.
     *
     * @return StarterModule[] The browsed modules indexed by their name and with the Module class instance as value.
     */
    public function getModules(): array
    {
        return $this->modules;
    }
}
