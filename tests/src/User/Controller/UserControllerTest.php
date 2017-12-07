<?php

namespace User\Controller;

use Test\BootstrapTestCase;

class UserControllerTest extends BootstrapTestCase
{
    /**
     * Test if the controller is loaded.
     */
    public function testUserControllerLoaded()
    {
        $this->assertInstanceOf(UserController::class, $this->app['user.controller.user']);
    }
    
    public function testGetUsersRoute()
    {
        $client  = $this->createClient();
        $client->request('GET', '/user/user');
        $this->assertFalse($client->getResponse()->isInvalid());
    }
    
    public function testGetUserRoute()
    {
        $client  = $this->createClient();
        $client->request('GET', '/user/user/1');
        $this->assertFalse($client->getResponse()->isInvalid());
        
        $client  = $this->createClient();
        $client->request('GET', '/user/user');
        $this->assertFalse($client->getResponse()->isInvalid());

        $client  = $this->createClient();
        $client->request('GET', '/user/user');
        $this->assertFalse($client->getResponse()->isInvalid());
    }
    
    public function testCreateUserRoute()
    {
        $client  = $this->createClient();
        $client->request('POST', '/user/user');
        $this->assertFalse($client->getResponse()->isInvalid());
    }
    
    public function testUpdateUserRoute()
    {
        $client  = $this->createClient();
        $client->request('PUT', '/user/user/1');
        $this->assertFalse($client->getResponse()->isInvalid());
    }
    
    public function testDeleteUserRoute()
    {
        $client  = $this->createClient();
        $client->request('DELETE', '/user/user/1');
        $this->assertFalse($client->getResponse()->isInvalid());
    }
}
