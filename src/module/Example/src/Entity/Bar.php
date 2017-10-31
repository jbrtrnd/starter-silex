<?php

namespace Example\Entity;

use Starter\Rest\RestEntity;

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
     * @Column(type="string")
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
}
