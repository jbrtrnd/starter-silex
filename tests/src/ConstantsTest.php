<?php

use PHPUnit\Framework\TestCase;

class ConstantsTest extends TestCase
{
    public function testConstantsDefined()
    {
        $this->assertTrue(defined('APP_ENV'));
        $this->assertTrue(defined('DIR_VENDORS'));
        $this->assertTrue(defined('DIR_MODULES'));
        $this->assertTrue(defined('DIR_CONFIG'));
    }
}
