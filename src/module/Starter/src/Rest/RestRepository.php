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
     * @param array|null $orderBy Array of orderBy specs.
     * @param int|null   $limit   Max. number of rows.
     * @param int|null   $offset  Start at row N.
     *
     * @return array The retrieved rows.
     */
    public function search(array $orderBy = null, int $limit = null, int $offset = null)
    {
        $queryBuilder = $this->createQueryBuilder('o');
        $queryBuilder->select('o');

        // Pagination
        $queryBuilder->setMaxResults($limit);
        $queryBuilder->setFirstResult($offset);

        // Sorting
        if ($orderBy) {
            foreach ($orderBy as $sort => $order) {
                if (strrpos($sort, '.') === false) {
                    $sort = 'o.' . $sort;
                }
                $queryBuilder->orderBy($sort, $order);
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
