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
     * Conditions specs will be parsed and use Doctrine Expr API. It should be an array of conditions that can
     * contains 4 parameters :
     * - "property" : the property ("foo")
     * - "operator" : the operator to apply ("eq", "neq", "gt" ... see Doctrine Expr)
     * - "value" : the value to test
     * - "noDot" : by default this function will add the "o." prefix to the condition property if not dot is found in
     * the property. You can override this behaviour by setting the "noDot" to false.
     *
     * @param array|null $criteria Array of conditions specs.
     * @param array|null $orderBy  Array of orderBy specs.
     * @param string     $mode     "and" or "or", condition mode.
     * @param int|null   $limit    Max. number of rows.
     * @param int|null   $offset   Start at row N.
     *
     * @return array The retrieved rows.
     */
    public function search(array $criteria = null, array $orderBy = null, string $mode = 'and', int $limit = null, int $offset = null)
    {
        $queryBuilder = $this->createQueryBuilder('o');
        $queryBuilder->select('o');

        // Filtering
        if ($criteria) {
            $i = 0;
            foreach ($criteria as $condition) {
                $property = $condition['property'];
                $operator = $condition['operator'];
                $value    = $condition['value'];
                $noDot    = $condition['noDot'] ?? false;

                // Add the "o." prefix if not dot found
                if (strrpos($property, '.') === false && !$noDot) {
                    $property = 'o.' . $property;
                }

                if ($operator == 'in') {
                    $value = explode(',', $value);
                }

                $predicate = $queryBuilder->expr()->$operator($property,  ':o' . $i);
                $queryBuilder->{$mode . 'Where'}($predicate);
                $queryBuilder->setParameter('o' . $i, $value);
                $i++;
            }
        }

        // Pagination
        $queryBuilder->setMaxResults($limit);
        $queryBuilder->setFirstResult($offset);

        // Sorting
        if ($orderBy) {
            foreach ($orderBy as $sort => $order) {
                // // Add the "o." prefix if not dot found
                if (strrpos($sort, '.') === false) {
                    $sort = 'o.' . $sort;
                }
                $queryBuilder->orderBy($sort, $order);
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
