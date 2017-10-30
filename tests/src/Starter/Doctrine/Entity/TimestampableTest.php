<?php

namespace Starter\Doctrine\Entity;

use PHPUnit\Framework\TestCase;
use TestModule\Entity\TestEntity;

/**
 * Class TimestampableTest
 *
 * @package Starter\Doctrine\Entity
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class TimestampableTest extends TestCase
{
    /**
     * Test the Timestampable trait
     */
    public function testTimestampableMethods()
    {
        $entity = new TestEntity();

        $this->assertTrue(method_exists($entity, 'setCreated'));
        $this->assertTrue(method_exists($entity, 'getCreated'));
        $this->assertTrue(method_exists($entity, 'setUpdated'));
        $this->assertTrue(method_exists($entity, 'getUpdated'));
    }
}
