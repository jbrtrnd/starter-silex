<?php

namespace Starter\Rest;

use Starter\Doctrine\Entity\Timestampable;

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
}
