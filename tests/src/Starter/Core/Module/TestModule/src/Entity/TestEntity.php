<?php

namespace TestModule\Entity;

use Starter\Doctrine\Entity\Timestampable;

class TestEntity
{
    use Timestampable;

    protected $foo;

    protected $relation;

    /**
     * @return mixed
     */
    public function getFoo(): string
    {
        return $this->foo;
    }

    /**
     * @param mixed $foo
     */
    public function setFoo(string $foo): void
    {
        $this->foo = $foo;
    }

    /**
     * @return mixed
     */
    public function getRelation(): array
    {
        return $this->relation;
    }

    /**
     * @param mixed $relation
     */
    public function setRelation(array $relation): void
    {
        $this->relation = $relation;
    }
}
