<?php

namespace Starter\Core\Http\JsonBody;

use Test\TestModuleTestCase;

/**
 * Class ServiceProviderTest
 *
 * @package Starter\Core\Http\JsonBody
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class ServiceProviderTest extends TestModuleTestCase
{
    /**
     * Test if the application can handle json content type request
     */
    public function testJsonBodyRequest()
    {
        $data = [
            'foo' => 'bar'
        ];

        $client  = $this->createClient();
        $client->request('POST', '/test_json', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode($data));

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals($data, json_decode($client->getResponse()->getContent(), true));
    }
}
