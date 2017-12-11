<?php

namespace User\Controller;

use Test\BootstrapTestCase;

class AuthenticationControllerTest extends BootstrapTestCase
{
    /**
     * Test if the controller is loaded.
     */
    public function testAuthenticationControllerLoaded()
    {
        $this->assertInstanceOf(AuthenticationController::class, $this->app['user.controller.authentication']);
    }

    public function testAuthenticateRoute()
    {
        $client  = $this->createClient();
        $client->request('GET', '/user/auth/authenticate');
        $this->assertFalse($client->getResponse()->isInvalid());
    }

    public function testValidateRoute()
    {
        $client  = $this->createClient();
        $client->request('GET', '/user/auth/validate');
        $this->assertFalse($client->getResponse()->isInvalid());
    }
}
