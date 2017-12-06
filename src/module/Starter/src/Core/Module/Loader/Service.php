<?php

namespace Starter\Core\Module\Loader;

use Pimple\Container;
use Starter\Core\Module\Loader\Exception\ModuleClassNotFoundException;
use Starter\Core\Module\StarterModule;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     *
     * @throws ModuleClassNotFoundException If the Module class is not found.
     */
    public function __construct(Container $application)
    {
        $this->application = $application;
        $this->loaded      = false;

        $this->retrieveModules();
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

        foreach ($this->modules as $module) {
            $module->afterApplicationLoad();
        }

        $configuration = $this->application['starter.configuration'];
        if (isset($configuration['http']['response']['header'])) {
            $headers = $configuration['http']['response']['header'];
            $this->application->after(function (Request $request, Response $response) use ($headers) {
                foreach ($headers as $key => $value) {
                    $response->headers->set($key, $value);
                }
            });
        }

        $this->loaded = true;
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

    /**
     * Set the modules.
     *
     * @param StarterModule[] $modules The modules to set.
     *
     * @return void
     */
    public function setModules(array $modules): void
    {
        $this->modules = $modules;
    }

    /**
     * Retrieve the modules to load.
     *
     * The modules are set in the $modules property with their name as key and the Module class instance as value.
     * The Starter Module will always be first because it must be loaded first.
     *
     * @throws ModuleClassNotFoundException If the Module class doesn't exist in the module src directory.
     *
     * @return void
     */
    protected function retrieveModules(): void
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

        uksort($this->modules, function (string $a, string $b) {
            return ($a === 'Starter' ? -1 : ($b === 'Starter' ? 1 : 0));
        });
    }
}
