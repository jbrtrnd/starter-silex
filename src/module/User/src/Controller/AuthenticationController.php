<?php

namespace User\Controller;

use Doctrine\ORM\EntityManager;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use User\Security\Token\Service as TokenService;

/**
 * The controller used to manage authentication.
 *
 * @package User\Controller
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class AuthenticationController
{
    /**
     * @var EntityManager The Doctrine entity manager.
     */
    protected $entityManager;

    /**
     * @var TokenService The token service.
     */
    protected $tokenService;

    /**
     * AuthenticationController constructor.
     *
     * @param Application $application The Silex application.
     */
    public function __construct(Application $application)
    {
        $this->entityManager = $application['orm.em'];
        $this->tokenService  = $application['user.service.security.token'];
    }

    /**
     * Authenticate an user by username and password.
     * If credentials are correct, return the user object and a valid JWT token.
     *
     * URL    : http(s)://host.ext/url/to/this/function?username=<USERNAME_VALUE>&password=<PASSWORD_VALUE>
     * Method : GET
     *
     * HTTP Status code :
     * - 200 : it's ok, user is authenticated
     * - 400 : one of the required parameter is missing
     * - 401 : credentials are wrong
     * - 500 : internal error
     *
     * Query parameters :
     * - "username" (required)
     * the username to test
     *
     * - "password" (required)
     * the password to test
     *
     * @param Request $request The current HTTP request.
     *
     * @return JsonResponse
     */
    public function authenticate(Request $request): JsonResponse
    {
        $status  = Response::HTTP_OK;
        $data    = null;

        $username = $request->get('username', false);
        $password = $request->get('password', false);

        if (!$username || !$password) {
            $status  = Response::HTTP_BAD_REQUEST;
        } else {
            $repository = $this->entityManager->getRepository('User\Entity\User');
            $user = $repository->authenticate($username, $password);
            if (!$user) {
                $status = Response::HTTP_UNAUTHORIZED;
            } else {
                $data = [
                    'user'  => $user,
                    'token' => $this->tokenService->generate(['user' => $user->getId()])
                ];
            }
        }

        return new JsonResponse($data, $status);
    }

    /**
     * Validate a JWT token.
     * Returns the decoded token if it's valid.
     *
     * URL    : http(s)://host.ext/url/to/this/function?token=<TOKEN_VALUE>
     * Method : GET
     *
     * HTTP Status code :
     * - 200 : it's ok, token is valid
     * - 400 : one of the required parameter is missing
     * - 401 : invalid token
     *
     * Query parameters :
     * - "token" (required)
     * the token to test
     *
     * @param Request $request The current HTTP request.
     *
     * @return JsonResponse
     */
    public function validate(Request $request): JsonResponse
    {
        $status = Response::HTTP_OK;
        $data = null;

        $token = $request->get('token', false);

        if (!$token) {
            $status = Response::HTTP_BAD_REQUEST;
        } else {
            try {
                $data = $this->tokenService->decode($token);
            } catch (\Exception $e) {
                $status = Response::HTTP_UNAUTHORIZED;
            }
        }

        return new JsonResponse($data, $status);
    }
}
