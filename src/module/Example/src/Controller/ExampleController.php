<?php

namespace Example\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * An example controller.
 *
 * @package Example\Controller
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ExampleController
{
    /**
     * ExampleController constructor.
     *
     * The Silex container is injected by the factory written in the routes.config.php..
     *
     * @param Application $application Silex container
     */
    public function __construct(Application $application)
    {
        // We can maybe retrieve some dependencies from the Silex global container
    }

    /**
     * Example of action returning a HTML response.
     *
     * @return Response
     */
    public function html(): Response
    {
        return new Response('Example as HTML');
    }

    /**
     * Example of action returning a JSON response.
     *
     * @return Response
     */
    public function json(): JsonResponse
    {
        return new JsonResponse(['Example as JSON']);
    }
}
