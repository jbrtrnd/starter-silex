<?php

namespace Example\Entity;

/**
 * Class Foo.
 *
 * An example of Doctrine entity.
 *
 * @package Example\Entity
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 *
 * @Entity
 * @Table(name="example_foo")
 */
class Foo
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
    protected $bar;

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
     * @param int $id Return the id property value.
     */
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    /**
     * Return the bar property value.
     *
     * @return string The bar property value.
     */
    public function getBar(): ?string
    {
        return $this->bar;
    }

    /**
     * Set the bar property value.
     *
     * @param string $bar Return the bar property value.
     * @return void
     */
    public function setBar(?string $bar): void
    {
        $this->bar = $bar;
    }
}
