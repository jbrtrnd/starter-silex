<?php

namespace Starter\Core\Configuration;

/**
 * Configuration wrapper.
 *
 * @package Starter\Core\Configuration
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Configuration implements \ArrayAccess
{
    /**
     * @var array Internal container.
     */
    protected $container = [];

    /**
     * Whether a offset exists.
     *
     * @param mixed $offset An offset to check for.
     * @return bool True on success or false on failure.
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Offset to retrieve.
     *
     * @param mixed $offset Offset to retrieve.
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Offset to set.
     *
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value The value to set.
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Offset to unset.
     *
     * @param mixed $offset The offset to unset.
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Return the full internal container.
     *
     * @return array
     */
    public function getInternalContainer(): array
    {
        return $this->container;
    }

    /**
     * Merge the current Configuration with another.
     *
     * @param Configuration $configuration The Configuration to merge with.
     * @return void
     */
    public function merge(Configuration $configuration): void
    {
        if (!is_array($this->container)) {
            $this->container = [];
        }
        $this->container = array_merge_recursive($this->container, $configuration->getInternalContainer());
    }
}
