<?php

namespace Starter\Core\Configuration;

use PHPUnit\Framework\TestCase;

/**
 * Class FactoryTest.
 *
 * @author Jules Bertrand <jules.brtrnd@gmail.com>
 */
class FactoryTest extends TestCase
{
    /**
     * Test if configuration is constructed from php array.
     */
    public function testConfigurationFromArray()
    {
        $container = [
            'simple' => 'value',
            'array'  => [1, 2, 3],
            'multi'  => [
                'a' => 1,
                'b' => 2
            ]
        ];

        $configuration = Factory::fromArray($container);

        $this->assertInstanceOf(Configuration::class, $configuration);
        $this->assertTrue($configuration->offsetExists('simple'));
        $this->assertTrue($configuration->offsetExists('array'));
        $this->assertTrue($configuration->offsetExists('multi'));
        $this->assertEquals($container, $configuration->getInternalContainer());
    }

    /**
     * Test if configuration is constructed from PHP file.
     */
    public function testConfigurationFromFile()
    {
        $path = __DIR__ . '/files/file1.config.php';

        $configuration = Factory::fromFile($path);

        $this->assertInstanceOf(Configuration::class, $configuration);
        $this->assertEquals(include $path, $configuration->getInternalContainer());
    }

    /**
     * Test if configuration is constructed from directory.
     */
    public function testConfigurationFromDirectory()
    {
        $path = __DIR__ . '/files/';

        $configuration = Factory::fromDirectory($path);

        $this->assertInstanceOf(Configuration::class, $configuration);

        $this->assertEquals([
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => [
                'key31' => 'value31',
                'key32' => 'value32'
            ]
        ], $configuration->getInternalContainer());
    }
}
