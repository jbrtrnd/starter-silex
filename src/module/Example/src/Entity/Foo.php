<?php

namespace Example\Entity;

use Starter\Doctrine\Entity\Timestampable;

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
    use Timestampable;

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
     * @param int $id The value to set.
     *
     * @return void
     */
    public function setId(?int $id): void
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
     * @param string $bar The value to set.
     *
     * @return void
     */
    public function setBar(?string $bar): void
    {
        $this->bar = $bar;
    }
}
