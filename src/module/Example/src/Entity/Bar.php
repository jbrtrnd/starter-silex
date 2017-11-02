<?php

namespace Example\Entity;

use Doctrine\ORM\EntityManager;
use Starter\Rest\RestEntity;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class Bar.
 *
 * An example of Starter REST entity.
 *
 * @package Example\Entity
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 *
 * @Entity(repositoryClass="Example\Repository\BarRepository")
 * @Table(name="example_bar")
 */
class Bar extends RestEntity
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string A random property.
     * @Column(type="string", nullable=false)
     */
    protected $baz;

    /**
     * Return the id property value.
     *
     * @return int The id property value.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the id property value.
     *
     * @param int $id The value to set.
     *
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Return the baz property value.
     *
     * @return string The baz property value.
     */
    public function getBaz(): ?string
    {
        return $this->baz;
    }

    /**
     * Set the baz property value.
     *
     * @param string $baz The value to set.
     *
     * @return void
     */
    public function setBaz(?string $baz): void
    {
        $this->baz = $baz;
    }

    /**
     * We can retrieve this data from the "embed" query parameter.
     *
     * @return array
     */
    public function getSomeRelation(): array
    {
        $a = new Bar();
        $a->setBaz('test1');
        $b = new Bar();
        $b->setBaz('test1');

        return [
            $a,
            $b
        ];
    }

    /**
     * Convert the current object into json array.
     *
     * @return array The serialized entity.
     */
    public function jsonSerialize(): array
    {
        return [
            'id'  => $this->getId(),
            'baz' => $this->getBaz()
        ];
    }

    /**
     * Return the Bar InputFilter for validating and filtering fields.
     *
     * @param EntityManager $entityManager The Doctrine entity manager.
     *
     * @return InputFilterInterface The InputFilter.
     */
    public function getInputFilter(EntityManager $entityManager): InputFilterInterface
    {
        $factory = new Factory();
        return $factory->createInputFilter([
            'id' => [
                'required' => false
            ],
            'baz' => [
                'required' => true
            ]
        ]);
    }
}
