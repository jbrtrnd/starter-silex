<?php

namespace Starter\Rest;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

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
    public function search(
        array $criteria = null,
        array $orderBy = null,
        string $mode = 'and',
        int $limit = null,
        int $offset = null
    ) {
        $queryBuilder = $this->createQueryBuilder('o');
        $queryBuilder->select('o');

        $this->beforeSearchCriteria($queryBuilder, $criteria);

        // Filtering
        if ($criteria) {
            $i = 0;
            foreach ($criteria as $criterion) {
                $property = $criterion['property'];
                $operator = $criterion['operator'];
                $value    = $criterion['value'];
                $noDot    = $criterion['noDot'] ?? false;

                // Add the "o." prefix if not dot found
                if (strrpos($property, '.') === false && !$noDot) {
                    $property = 'o.' . $property;
                }

                if ($operator === 'in') {
                    $value = explode(',', $value);
                }

                if ($operator === 'isNull') {
                    $predicate = $queryBuilder->expr()->$operator($property);
                } else {
                    $predicate = $queryBuilder->expr()->$operator($property, ':o' . $i);
                    $queryBuilder->setParameter('o' . $i, $value);
                    $i++;
                }
                $queryBuilder->{$mode . 'Where'}($predicate);
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

        $this->beforeSearchExecute($queryBuilder);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Allow you to perform some specific code before the Doctrine conversion of the array of criteria to Doctrine
     * Query builder expressions.
     *
     * Useful to add joins.
     *
     * @param QueryBuilder $queryBuilder The current query builder.
     * @param array|null   $criteria     The criteria.
     *
     * @return void
     */
    protected function beforeSearchCriteria(QueryBuilder $queryBuilder, ?array &$criteria): void
    {
    }

    /**
     * Allow you to perform som specific code before query executing.
     *
     * @param QueryBuilder $queryBuilder
     *
     * @return void
     */
    protected function beforeSearchExecute(QueryBuilder $queryBuilder): void
    {
    }
}
