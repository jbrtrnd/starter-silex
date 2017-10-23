<?php

namespace Starter\Core\Module;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The starter middleware base class.
 *
 * Extend this class and implement the call() function to write your own middleware.
 *
 * @package Starter\Core\Module\Middleware
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
abstract class StarterMiddleware
{
    /**
     * @var Application The silex application.
     */
    protected $application;

    /**
     * @var Request The current HTTP request.
     */
    protected $request;

    /**
     * StarterMiddleware constructor.
     *
     * @param Request $request The current HTTP request.
     * @param Application $application The silex application.
     */
    public function __construct(Request $request, Application $application)
    {
        $this->request     = $request;
        $this->application = $application;
    }

    /**
     * Execute the middleware.
     *
     * The Silex application will call this function when it should execute the middleware.
     *
     * @return null|Response
     */
    abstract public function call(): ?Response;
}
