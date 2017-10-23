<?php

namespace Starter\Core\Configuration;

use PHPUnit\Framework\TestCase;

/**
 * Class ConfigurationTest.
 *
 * @author Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ConfigurationTest extends TestCase
{
    /**
     * Test array access of configuration.
     */
    public function testConfigurationArrayAccess()
    {
        $offset = 'someOffset';
        $value  = 'someValue';

        $configuration = new Configuration();

        $this->assertFalse($configuration->offsetExists($offset));
        $configuration->offsetSet($offset, $value);

        $this->assertTrue($configuration->offsetExists($offset));
        $this->assertEquals($value, $configuration->offsetGet($offset));

        $configuration->offsetUnset($offset);

        $this->assertFalse($configuration->offsetExists($offset));
    }
}
