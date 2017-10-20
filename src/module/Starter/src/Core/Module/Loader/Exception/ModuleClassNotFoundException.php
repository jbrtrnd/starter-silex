<?php

namespace Starter\Core\Module\Loader\Exception;

use Throwable;

/**
 * Class ModuleClassNotFoundException
 *
 * Exception thrown is the Module class is missing for a module.
 *
 * @package Starter\Core\Module\Loader\Exception
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ModuleClassNotFoundException extends \Exception
{
    /**
     * Construct the exception
     *
     * @param string $module The module name where the Module class is missing
     * @param int $code The Exception code.
     * @param Throwable $previous The previous throwable used for the exception chaining.
     * @since 5.1.0
     */
    public function __construct($module, $code = 0, Throwable $previous = null)
    {
        $message = 'The Module class seems missing for the module ' . $module . '.';

        parent::__construct($message, $code, $previous);
    }
}
