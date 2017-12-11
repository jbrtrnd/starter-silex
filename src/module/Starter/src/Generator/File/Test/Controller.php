<?php

namespace Starter\Generator\File\Test;

use Starter\Generator\File;

/**
 * Generate a controller test class file.
 *
 * @package Starter\Generator\File\Test
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
        if (!is_dir(DIR_TESTS . '/' . $this->module)) {
            throw new \RuntimeException('Error while creating ' . $this->getFilename() . ' : Module doesn\'t exists.');
        }

        if (!is_dir(DIR_TESTS . '/' . $this->module . '/Controller')) {
            mkdir(DIR_TESTS . '/' . $this->module . '/Controller');
        }

        parent::create();
    }


    /**
     * Return the full name of the file (path included).
     *
     * @return string
     */
    public function getFilename(): string
    {
        return DIR_TESTS . '/' . $this->module . '/Controller/' . $this->controller . 'Test.php';
    }

    /**
     * Content of a controller file.
     *
     * @return string
     */
    public function generate(): string
    {
        $controllerKey = strtolower($this->module . '.controller.' . $this->entity);
        $entityRoute = '/' . strtolower($this->module) . '/' . strtolower($this->entity);

        return <<<EOT
<?php

namespace $this->module\Controller;

use Test\BootstrapTestCase;

class {$this->controller}Test extends BootstrapTestCase
{
    /**
     * Test if the controller is loaded.
     */
    public function test{$this->controller}Loaded()
    {
        \$this->assertInstanceOf({$this->controller}::class, \$this->app['$controllerKey']);
    }
    
    public function testGet{$this->entity}sRoute()
    {
        \$client  = \$this->createClient();
        \$client->request('GET', '$entityRoute');
        \$this->assertFalse(\$client->getResponse()->isInvalid());
    }
    
    public function testGet{$this->entity}Route()
    {
        \$client  = \$this->createClient();
        \$client->request('GET', '$entityRoute/random_id');
        \$this->assertFalse(\$client->getResponse()->isInvalid());
    }
    
    public function testCreate{$this->entity}Route()
    {
        \$client  = \$this->createClient();
        \$client->request('POST', '$entityRoute');
        \$this->assertFalse(\$client->getResponse()->isInvalid());
    }
    
    public function testUpdate{$this->entity}Route()
    {
        \$client  = \$this->createClient();
        \$client->request('PUT', '$entityRoute/random_id');
        \$this->assertFalse(\$client->getResponse()->isInvalid());
    }
    
    public function testDelete{$this->entity}Route()
    {
        \$client  = \$this->createClient();
        \$client->request('DELETE', '$entityRoute/random_id');
        \$this->assertFalse(\$client->getResponse()->isInvalid());
    }
}

EOT;
    }
}
