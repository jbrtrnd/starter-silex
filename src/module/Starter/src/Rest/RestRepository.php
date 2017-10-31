<?php

namespace Starter\Rest;

use Doctrine\ORM\EntityRepository;

/**
 * The basic starter REST repository.
 *
 * @package Starter\Rest
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class RestRepository extends EntityRepository
{
    /**
     * Method used in the search action of the RestController.
     *
     * @return array
     */
    public function search()
    {
        return $this->findAll();
    }
}
