<?php

namespace User\Repository;

use Starter\Rest\RestRepository;
use User\Entity\User;

/**
 * The custom repository for the User entity.
 *
 * @package User\Repository
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class UserRepository extends RestRepository
{
    /**
     * Check if a username is already used by another user.
     *
     * @param string   $username The username to test.
     * @param int|null $id       The optional id to test if the user is already registered.
     *
     * @return bool The unique state of the username.
     */
    public function usernameIsUnique(string $username, ?int $id): bool
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->where('u.username = :username')
                     ->andWhere('u.id != :id')
                     ->setParameters([
                         'id'       => $id ?? '',
                         'username' => $username
                     ]);

        $user = $queryBuilder->getQuery()->getOneOrNullResult();
        return $user === null;
    }

    /**
     * Return a user by a username password combination.
     *
     * @param string $username The username to use.
     * @param string $password The password to use.
     *
     * @return null|User The retrieved user or null.
     */
    public function authenticate(string $username, string $password): ?User
    {
        $user = $this->findOneBy([
            'username' => $username
        ]);

        if ($user && password_verify($password, $user->getPassword())) {
            return $user;
        }

        return null;
    }
}
