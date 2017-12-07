<?php

namespace User\Repository;

use Starter\Rest\RestRepository;

/**
 * The custom repository for the User entity.
 *
 * @package User\Repository
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class UserRepository extends RestRepository
{
    public function usernameIsUnique(string $username, ?int $id): bool
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->where('u.username = :username')
                     ->andWhere('u.id != :id')
                     ->setParameters([
                         'id'       => $id ?? '',
                         'username' => $username,
                     ]);

        $user = $queryBuilder->getQuery()->getOneOrNullResult();
        return $user === null;
    }
}
