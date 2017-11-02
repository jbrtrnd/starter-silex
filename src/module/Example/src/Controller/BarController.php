<?php

namespace Example\Controller;

use Silex\Application;
use Starter\Rest\RestController;

/**
 * The REST controller for the Bar entity.
 *
 * @package Example\Controller
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class BarController extends RestController
{
    /**
     * BarController constructor.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        parent::__construct('Example\Entity\Bar', $application);
    }
}
