<?php

class ConstantsTest extends \PHPUnit\Framework\TestCase
{
    public function testConstantsDefined()
    {
        $this->assertTrue(defined('APP_ENV'));
        $this->assertTrue(defined('DIR_VENDORS'));
        $this->assertTrue(defined('DIR_MODULES'));
        $this->assertTrue(defined('DIR_CONFIG'));
    }
}
