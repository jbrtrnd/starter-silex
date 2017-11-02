<?php

namespace Starter\Utils;

use PHPUnit\Framework\TestCase;
use TestModule\Entity\TestEntity;

/**
 * Class SerializerTest
 *
 * @package Starter\Utils
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class SerializerTest extends TestCase
{
    /**
     * Test serialization of simple property.
     */
    public function testSimpleProperty()
    {
        $entity = $this->createEntity();

        $serialized = Serializer::serialize($entity, ['foo']);
        $this->assertEquals([
            'foo' => 'someValue'
        ], $serialized);

    }

    /**
     * Test serialization of DateTime.
     */
    public function testDateTimeProperty()
    {
        $entity = $this->createEntity();

        $serialized = Serializer::serialize($entity, ['foo', 'created']);
        $this->assertTrue(is_string($serialized['created']));
    }

    /**
     * Test serialization of relation.
     */
    public function testRelationProperty()
    {
        $entity = $this->createEntity();

        $serialized = Serializer::serialize($entity, ['foo', 'relation.foo']);
        $this->assertEquals([
            'foo'      => 'someValue',
            'relation' => [
                [
                    'foo' => 'someRel1Value'
                ],
                [
                    'foo' => 'someRel2Value'
                ]
            ]
        ], $serialized);
    }

    protected function createEntity(): TestEntity
    {
        $entity = new TestEntity();
        $entity->setFoo('someValue');
        $entity->setCreated(new \DateTime());

        $rel1 = new TestEntity();
        $rel1->setFoo('someRel1Value');
        $rel1->setCreated(new \DateTime());

        $rel2 = new TestEntity();
        $rel2->setFoo('someRel2Value');
        $rel2->setCreated(new \DateTime());

        $entity->setRelation([
            $rel1,
            $rel2
        ]);

        return $entity;
    }
}
