<?php

namespace Starter\Generator;

/**
 * Abstract class file used to generate files.
 *
 * @package Starter\Generator
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
abstract class File
{
    /**
     * Return the file content.
     *
     * @return string The file content.
     */
    abstract public function generate(): string;

    /**
     * Return the full name of the file (path included).
     *
     * @return string The file full name.
     */
    abstract public function getFilename(): string;

    /**
     * Create the file.
     *
     * @throws \RuntimeException When the file already exists.
     *
     * @return void
     */
    public function create(): void
    {
        $filename = $this->getFilename();

        if (file_exists($filename)) {
            throw new \RuntimeException('Error while creating ' . $filename . ' : File already exists.');
        }

        file_put_contents($this->getFilename(), $this->generate());
    }
}
