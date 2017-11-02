<?php

namespace Starter\Generator\File;

use Starter\Generator\File;

/**
 * Generate a repository class file.
 *
 * @package Starter\Generator\File
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Repository extends File
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
     * @var string The repository name.
     */
    protected $repository;

    /**
     * Repository constructor.
     *
     * @param string $entity Entity name.
     * @param string $module Module name.
     */
    public function __construct(string $entity, string $module)
    {
        $this->entity     = ucfirst($entity);
        $this->module     = ucfirst($module);
        $this->repository = ucfirst($entity) . 'Repository';
    }

    /**
     * Create the file.
     *
     * The "Repository" module dir will be created if don't exist.
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

        if (!is_dir(DIR_MODULES . '/' . $this->module . '/src/Repository')) {
            mkdir(DIR_MODULES . '/' . $this->module . '/src/Repository');
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
        return DIR_MODULES . '/' . $this->module . '/src/Repository/' . $this->repository . '.php';
    }

    /**
     * Content of a repository file.
     *
     * @return string
     */
    public function generate(): string
    {
        return <<<EOT
<?php

namespace $this->module\Repository;

use Starter\Rest\RestRepository;

/**
 * The custom repository for the $this->entity entity.
 *
 * @package $this->module\Repository
 */
class $this->repository extends RestRepository
{
}

EOT;
    }
}
