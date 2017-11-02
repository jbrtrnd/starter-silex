<?php

namespace Starter\Generator\File;

use Starter\Generator\File;

/**
 * Generate a controller class file.
 *
 * @package Starter\Generator\File
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Controller extends File
{
    /**
     * @var string The entity name.
     */
    protected $entity;

    /**
     * @var string The module name.
     */
    protected $module;

    /**
     * @var string The controller name.
     */
    protected $controller;

    /**
     * Controller constructor.
     *
     * @param string $entity Entity name.
     * @param string $module Module name.
     */
    public function __construct(string $entity, string $module)
    {
        $this->entity     = ucfirst($entity);
        $this->module     = ucfirst($module);
        $this->controller = ucfirst($entity) . 'Controller';
    }

    /**
     * Create the file.
     *
     * The "Controller" module dir will be created if don't exists.
     *
     * @throws \RuntimeException When the module directory doesn't exists.
     *
     * @return void
     */
    public function create(): void
    {
        if (!is_dir(DIR_MODULES . '/' . $this->module)) {
            throw new \RuntimeException('Error while creating ' . $this->getFilename() . ' : Module doesn\'t exists.');
        }

        if (!is_dir(DIR_MODULES . '/' . $this->module . '/src/Controller')) {
            mkdir(DIR_MODULES . '/' . $this->module . '/src/Controller');
        }

        parent::create();

        $this->writeRoutes();
    }


    /**
     * Return the full name of the file (path included).
     *
     * @return string
     */
    public function getFilename(): string
    {
        return DIR_MODULES . '/' . $this->module . '/src/Controller/' . $this->controller . '.php';
    }

    /**
     * Content of a controller file.
     *
     * @return string
     */
    public function generate(): string
    {
        return <<<EOT
<?php

namespace $this->module\Controller;

use Silex\Application;
use Starter\Rest\RestController;

/**
 * The REST controller for the $this->entity entity.
 *
 * @package $this->module\Controller
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class $this->controller extends RestController
{
    /**
     * $this->controller constructor.
     *
     * @param Application \$application
     */
    public function __construct(Application \$application)
    {
        parent::__construct('$this->module\Entity\\$this->entity', \$application);
    }
}

EOT;
    }

    /**
     * Write routes and controllers in the routes config file.
     *
     * TODO : backup the file before modifying it
     *
     * @return void
     */
    protected function writeRoutes(): void
    {
        $base = file_get_contents(DIR_MODULES . '/' . $this->module . '/config/routes.config.php');

        $content = '';

        $head = [];
        preg_match('/<\?php.*[\'|"]controllers[\'|"].*=>/sU', $base, $head);
        $content .= $head[0];

        $controllers = [];
        preg_match('/[\'|"]controllers[\'|"].*=>(.*)],.*[\'|"]routes[\'|"]/sU', $base, $controllers);
        $content .= rtrim($controllers[1]);

        if (substr($content, -1) !== ',' && sizeOf(trim($controllers[1])) > 1) {
            $content .= ',';
        }
        $content .= PHP_EOL;

        $controllerKey = strtolower($this->module . '.controller.' . $this->entity);

        $content .= <<<EOT
        '$controllerKey' => function (Application \$application) {
            return new Controller\\$this->controller(\$application);
        },
    ],
    
EOT;

        $routes = [];
        preg_match('/([\'|"]routes[\'|"].*=>.*\[)(.*)(];.*)$/sU', $base, $routes);
        $content .= rtrim($routes[1]);
        $content .= PHP_EOL;

        $entityRoute = '/' . strtolower($this->module) . '/' . strtolower($this->entity);

        $content .= <<<EOT
        '$entityRoute' => [
            'GET' => [
                'controller' => '$controllerKey',
                'action'     => 'search'
            ],
            'POST' => [
                'controller' => '$controllerKey',
                'action'     => 'create'
            ],
        ],
        '$entityRoute/:id' => [
            'GET' => [
                'controller' => '$controllerKey',
                'action'     => 'get'
            ],
            'PUT' => [
                'controller' => '$controllerKey',
                'action'     => 'update'
            ],
            'DELETE' => [
                'controller' => '$controllerKey',
                'action'     => 'delete'
            ],
        ],
EOT;

        $content .= $routes[2];
        $content .= rtrim($routes[3]) . PHP_EOL;

        file_put_contents(DIR_MODULES . '/' . $this->module . '/config/routes.config.php', $content);
    }
}
