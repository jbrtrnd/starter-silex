<?php

namespace User\Security\Middleware\Authentication;

use Doctrine\ORM\EntityManager;
use Silex\Application;
use Starter\Core\Module\StarterMiddleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use User\Security\Token\Service as TokenService;

/**
 * Control if a token is valid and present in a request.
 *
 * @package User\Security\Middleware\Authentication
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class AuthenticatedMiddleware extends StarterMiddleware
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var TokenService
     */
    protected $tokenService;

    /**
     * AuthenticatedMiddleware constructor.
     *
     * @param Request       $request     The current HTTP request.
     * @param Response|null $response    The current HTTP response (only in after middleware).
     * @param Application   $application The silex application.
     */
    public function __construct(Request $request, ?Response $response, Application $application)
    {
        parent::__construct($request, $response, $application);

        $this->entityManager = $this->application['orm.em'];
        $this->tokenService  = $this->application['user.service.security.token'];
    }

    /**
     * Send a 401 response if the token isn't valid or the user does not exist in the database.
     *
     * @return null|Response
     */
    public function call(): ?Response
    {
        $service = $this->application['user.service.security.token'];
        $token = $service->retrieve($this->request);
        if ($token) {
            try {
                $data = $service->decode($token);
                $user = $this->application['orm.em']->getRepository('User\Entity\User')->find($data['user']);
                if ($user) {
                    return null;
                }
            } catch (\Exception $e) {
                return $this->reject();
            }
        }

        return $this->reject();
    }

    /**
     *
     *
     * @return Response A 401 response.
     */
    protected function reject(): Response
    {
        return new Response(null, Response::HTTP_UNAUTHORIZED);
    }
}
