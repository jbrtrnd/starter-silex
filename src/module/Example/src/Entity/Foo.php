<?php

namespace Example\Entity;

/**
 * Class Foo
 *
 * An example of Doctrine entity
 *
 * @package Example\Entity
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Foo
{
    /**
     * @var string A random property
     */
    protected $bar;

    /**
     * Return the bar property value
     *
     * @return string The bar property value
     */
    public function getBar(): string
    {
        return $this->bar;
    }

    /**
     * Set the bar property value
     *
     * @param string $bar Value to set
     */
    public function setBar(string $bar)
    {
        $this->bar = $bar;
    }
}
