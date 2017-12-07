<?php

namespace User\Security\Middleware;

use Starter\Core\Module\StarterMiddleware;
use Symfony\Component\HttpFoundation\Response;

/**
 * Retrieve the current user from a JWT retrieved by the token service.
 *
 * @package User\Security\Middleware
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class CurrentUserMiddleware extends StarterMiddleware
{
    /**
     * Retrieve the current user from a JWT retrieved by the token service and store it in the request at the
     * "user.current" key.
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
                    $this->request->request->set('user.current', $user);
                }
            } catch (\Exception $e) {
            }
        }

        return null;
    }
}
