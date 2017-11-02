<?php

namespace Starter\Core\Module\Loader\Exception;

use Throwable;

/**
 * Class WrongMiddlewareClassException.
 *
 * Exception thrown if an affected middleware is not instance of StarterMiddleware.
 *
 * @package Starter\Core\Module\Loader\Exception
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class WrongMiddlewareClassException extends \Exception
{
    /**
     * Construct the exception.
     *
     * @param string    $class    The class name of the middleware.
     * @param int       $code     The Exception code.
     * @param Throwable $previous The previous throwable used for the exception chaining.
     */
    public function __construct($class, $code = 0, Throwable $previous = null)
    {
        $message = 'The class ' . $class . ' doesn\'t  inherits StarterMiddleware.';

        parent::__construct($message, $code, $previous);
    }
}
