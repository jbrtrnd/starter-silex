<?php

namespace Starter\Rest;

use Starter\Doctrine\Entity\Timestampable;

/**
 * The basic starter REST entity.
 *
 * @package Starter\Rest
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
abstract class RestEntity
{
    use Timestampable;
}
