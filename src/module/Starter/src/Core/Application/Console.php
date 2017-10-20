<?php

namespace Starter\Core\Application;

use Symfony\Component\Console\Application;

/**
 * Wrapper around a Symfony console application
 *
 * @package Starter\Core\Application
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Console extends Bootstrap
{
    /**
     * @var Application The Symfony console application
     */
    protected $console;

    /**
     * Console constructor
     *
     * Will create the Symfony console application without launching it.
     */
    public function __construct()
    {
        parent::__construct();
        $this->console = new Application();
    }

    /**
     * Return the Symfony console application
     *
     * @return Application The Symfony console application
     */
    public function getConsole(): Application
    {
        return $this->console;
    }

    /**
     * Launch the Symfony console application
     *
     * When calling this function, the console application is able to process input commands.
     */
    public function run(): void
    {
        $this->console->run();
    }
}
