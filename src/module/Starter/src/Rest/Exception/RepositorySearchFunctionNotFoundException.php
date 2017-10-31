<?php

namespace Starter\Rest\Exception;

use Throwable;

/**
 * Class RepositorySearchFunctionNotFoundException.
 *
 * Exception thrown if the search function is not found in the repository.
 *
 * @package Starter\Rest\Exception
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class RepositorySearchFunctionNotFoundException extends \Exception
{
    /**
     * Construct the exception.
     *
     * @param string $function The missing function.
     * @param string $entityClass The entity class.
     * @param int $code The Exception code.
     * @param Throwable $previous The previous throwable used for the exception chaining.
     */
    public function __construct(string $function, string $entityClass, $code = 0, Throwable $previous = null)
    {
        $message = 'The "' . $function . '" repository function for the entity "' . $entityClass . '" seems missing.';

        parent::__construct($message, $code, $previous);
    }
}
