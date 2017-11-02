<?php

namespace Example\Repository;

use Doctrine\ORM\QueryBuilder;
use Starter\Rest\RestRepository;

/**
 * The custom repository for the Bar entity.
 *
 * @package Example\Repository
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class BarRepository extends RestRepository
{
    /**
     * Add Bar joins to allow querying them.
     *
     * @param QueryBuilder $queryBuilder The current query builder.
     * @param array|null   $criteria     The criteria.
     *
     * @return void
     */
    protected function beforeSearchCriteria(QueryBuilder $queryBuilder, ?array &$criteria): void
    {
        // "$queryBuilder->join('o.relation', 'relation')" allow you to query relations with "relation.property=value"
    }
}
