<?php

namespace Starter\Rest;

use Doctrine\ORM\EntityManager;
use Starter\Doctrine\Entity\Timestampable;
use Zend\InputFilter\InputFilterInterface;

/**
 * The basic starter REST entity.
 *
 * @package Starter\Rest
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
abstract class RestEntity implements \JsonSerializable
{
    use Timestampable;

    /**
     * Convert the current object into json array.
     *
     * @return array The serialized entity.
     */
    abstract public function jsonSerialize(): array;

    /**
     * Return the entity InputFilter for validating and filtering fields.
     *
     * @param EntityManager $entityManager The Doctrine entity manager.
     *
     * @return InputFilterInterface The InputFilter.
     */
    abstract public function getInputFilter(EntityManager $entityManager): InputFilterInterface;
}
