<?php

namespace User\Security\Middleware\User;

use Silex\Application;
use Starter\Core\Module\StarterMiddleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use User\Security\Token\Service as TokenService;

/**
 * Retrieve the current user from a JWT retrieved by the token service.
 *
 * @package User\Security\Middleware\User
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class CurrentUserMiddleware extends StarterMiddleware
{
    /**
     * @var TokenService
     */
    protected $tokenService;

    /**
     * CurrentUserMiddleware constructor.
     *
     * @param Request       $request     The current HTTP request.
     * @param Response|null $response    The current HTTP response (only in after middleware).
     * @param Application   $application The silex application.
     */
    public function __construct(Request $request, ?Response $response, Application $application)
    {
        parent::__construct($request, $response, $application);

        $this->tokenService = $this->application['user.service.security.token'];
    }

    /**
     * Retrieve the current user from a JWT retrieved by the token service and store it in the request at the
     * "user.current" key.
     *
     * @return null|Response
     */
    public function call(): ?Response
    {
        $token = $this->tokenService->retrieve($this->request);
        if ($token) {
            try {
                $data = $this->tokenService->decode($token);
                $user = $this->application['orm.em']->getRepository('User\Entity\User')->find($data['user']);
                if ($user) {
                    $this->request->request->set('user.current', $user);
                }
            } catch (\Exception $e) {
            }
        }

        return null;
    }
}
