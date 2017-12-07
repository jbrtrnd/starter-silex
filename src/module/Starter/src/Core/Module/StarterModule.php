<?php

namespace Starter\Core\Module;

use Pimple\Container;
use Silex\Controller;
use Starter\Core\Configuration\Configuration;
use Starter\Core\Configuration\Factory as ConfigurationFactory;
use Starter\Core\Module\Loader\Exception\WrongMiddlewareClassException;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The starter module base class.
 *
 * Every custom module must have a Module class definition in their src directory.
 *
 * @package Starter\Core\Module
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
abstract class StarterModule
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
     * @var string The directory containing the module (not the Module class).
     */
    protected $directory;

    /**
     * @var Configuration The module configuration retrieved from the config directory.
     */
    protected $configuration;

    /**
     * StarterModule constructor.
     *
     * @param Container $application The Silex container.
     */
    public function __construct(Container $application)
    {
        $this->application = $application;
        $this->loaded      = false;

        $reflection = new \ReflectionClass($this);
        $this->directory = dirname($reflection->getFileName(), 2);

        $this->configuration = ConfigurationFactory::fromDirectory($this->directory . '/config');
    }

    /**
     * Load the current module in the Silex container.
     *
     * @return void
     */
    public function load(): void
    {
        if (!$this->loaded) {
            $this->loadControllers();
            $this->loadRoutes();
            $this->loadMapping();

            $this->afterLoad();

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

    /**
     * Get the module configuration.
     *
     * @return Configuration The module configuration.
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * Load the controllers from the configurations files in the Silex container.
     *
     * The controllers must be at the "controllers" key, see
     * {@link https://silex.symfony.com/doc/2.0/providers/service_controller.html}.
     *
     * @return void
     */
    protected function loadControllers(): void
    {
        $key = 'controllers';

        if ($this->configuration->offsetExists($key)) {
            foreach ($this->configuration->offsetGet($key) as $name => $controller) {
                $this->application[$name] = $controller;
            }
        }
    }

    /**
     * Load the routes from the configurations files in the Silex container.
     *
     * The routes must be at the "routes" key.
     *
     * @return void
     */
    protected function loadRoutes(): void
    {
        $key = 'routes';

        if ($this->configuration->offsetExists($key)) {
            foreach ($this->configuration->offsetGet($key) as $url => $entries) {
                // For each url, assign the OPTIONS method (called by browser) and returns a default response
                $this->application->options($url, function () {
                    return new Response();
                });

                foreach ($entries as $methods => $definition) {
                    foreach (explode(',', $methods) as $method) {
                        $controller = $definition['controller'];
                        $action     = $definition['action'];

                        $route = $this->application->{$method}($url, $controller . ':' . $action);

                        $this->loadMiddlewares($route, $definition, 'before');
                        $this->loadMiddlewares($route, $definition, 'after');
                    }
                }
            }
        }
    }

    /**
     * Load the middlewares of a route definition.
     *
     * @param Controller $route      Controller object to affect the middleware.
     * @param array      $definition Route definition array.
     * @param string     $type       Type of middleware ("after" or "before").
     *
     * @return void
     */
    protected function loadMiddlewares(Controller $route, array $definition, string $type = 'before'): void
    {
        if ($type !== 'before' && $type !== 'after') {
            return;
        }

        if (isset($definition[$type])) {
            $middlewares = $definition[$type];

            if (!is_array($middlewares)) {
                $middlewares = [$middlewares];
            }

            foreach ($middlewares as $class) {
                $route->{$type}(
                    function (
                        Request $request,
                        $arg1,
                        $arg2 = null
                    ) use (
                        $type,
                        $class
                    ) {
                        $application = $type === 'after' ? $arg2 : $arg1;
                        $response    = $type === 'after' ? $arg1 : null;

                        $middleware = new $class($request, $response, $application);
                        if (!$middleware instanceof StarterMiddleware) {
                            throw new WrongMiddlewareClassException($class);
                        }
                        return $middleware->call();
                    }
                );
            }
        }
    }

    /**
     * Load Doctrine mapping configuration.
     *
     * Be default, the entities should be in the MyModule\Entity namespace located in the src/Entity directory of
     * the module.
     *
     * @return void
     */
    protected function loadMapping(): void
    {
        $key = 'orm.em.options';
        if ($this->application->offsetExists($key)) {
            $directory = $this->directory . '/src/Entity';
            if (is_dir($directory)) {
                $options = $this->application->offsetGet($key);

                $reflection = new \ReflectionClass($this);
                $namespace = $reflection->getNamespaceName();

                $options['mappings'][] = [
                    'type'      => 'annotation',
                    'namespace' => $namespace . '\Entity',
                    'path'      => $directory
                ];

                $this->application->offsetSet($key, $options);
            }
        }
    }

    /**
     * Execute some code when the module is loaded.
     *
     * @return void
     */
    protected function afterLoad(): void
    {
    }

    /**
     * Execute some code when all the modules are loaded.
     *
     * Called in the Module service loader.
     *
     * @return void
     */
    public function afterApplicationLoad(): void
    {
    }

    /**
     * Execute some code when all the modules are loaded, in console mode.
     *
     * Called in Console application.
     *
     * @param Console $console The console application.
     *
     * @return void
     */
    public function afterConsoleLoad(Console $console): void
    {
    }
}
