<?php

namespace Starter\Generator\File;

use Starter\Generator\File;

/**
 * Generate an entity class file.
 *
 * @package Starter\Generator\File
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Entity extends File
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
     * @var string The entity repository name.
     */
    protected $repository;

    /**
     * @var string The entity table name.
     */
    protected $table;

    /**
     * Entity constructor.
     *
     * @param string $entity Entity name.
     * @param string $module Module name.
     */
    public function __construct(string $entity, string $module)
    {
        $this->entity     = ucfirst($entity);
        $this->module     = ucfirst($module);
        $this->repository = ucfirst($entity) . 'Repository';
        $this->table      = strtolower($module) . '_' . strtolower($entity);
    }

    /**
     * Create the file.
     *
     * The "Entity" module dir will be created if don't exists.
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

        if (!is_dir(DIR_MODULES . '/' . $this->module . '/src/Entity')) {
            mkdir(DIR_MODULES . '/' . $this->module . '/src/Entity');
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
        return DIR_MODULES . '/' . $this->module . '/src/Entity/' . $this->entity . '.php';
    }

    /**
     * Content of an entity file.
     *
     * @return string
     */
    public function generate(): string
    {
        return <<<EOT
<?php

namespace $this->module\Entity;

use Doctrine\ORM\EntityManager;
use Starter\Rest\RestEntity;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilterInterface;

/**
 * $this->entity entity.
 *
 * @package $this->module\Entity
 *
 * @Entity(repositoryClass="$this->module\Repository\\$this->repository")
 * @Table(name="$this->table")
 */
class $this->entity extends RestEntity
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected \$id;
    
    /**
     * Return the id property value.
     *
     * @return int The id property value.
     */
    public function getId(): ?int
    {
        return \$this->id;
    }

    /**
     * Set the id property value.
     *
     * @param int \$id The value to set.
     *
     * @return void
     */
    public function setId(?int \$id): void
    {
        \$this->id = \$id;
    }
    
    /**
     * Convert the current object into json array.
     *
     * @return array The serialized entity.
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => \$this->getId()
            // TODO : add serialized fields
        ];
    }
    
    /**
     * Return the $this->entity InputFilter for validating and filtering fields.
     *
     * @param EntityManager \$entityManager The Doctrine entity manager.
     *
     * @return InputFilterInterface The InputFilter.
     */
    public function getInputFilter(EntityManager \$entityManager): InputFilterInterface
    {
        \$factory = new Factory();
        return \$factory->createInputFilter([
            'id' => [
                'required' => false
            ],
            // TODO : add validation rules
        ]);
    }
}

EOT;
    }
}
