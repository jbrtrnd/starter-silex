<?php

namespace User\Controller;

use Silex\Application;
use Starter\Rest\Exception\RepositorySearchFunctionNotFoundException;
use Starter\Rest\RestController;

/**
 * The REST controller for the User entity.
 *
 * @package User\Controller
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class UserController extends RestController
{
    /**
     * UserController constructor.
     *
     * @param Application $application
     *
     * @throws RepositorySearchFunctionNotFoundException If the repository don't contain the REST search function.
     */
    public function __construct(Application $application)
    {
        parent::__construct('User\Entity\User', $application);
    }
}
