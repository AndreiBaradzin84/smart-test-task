<?php

use PHPUnit\Framework\TestCase;
use SmartTest\UniqueHandler;

require_once 'vendor/autoload.php';

class UniqueHandlerTest extends TestCase
{
    protected $test_data;
    protected $expected_data;

    protected function setUp(): void
    {
        $this->test_data = [
            ['/home', '192.168.1.1'],
            ['/home', '192.168.1.1'],
            ['/help', '192.168.1.1'],
            ['/help', '192.168.1.2'],
            ['/help', '192.168.1.2']
        ];

        $this->expected_data = [
            ['/home', '192.168.1.1'],
            ['/help', '192.168.1.1'],
            ['/help', '192.168.1.2']
        ];
    }

    public function testGetUnique(): void
    {
        $unique_handler = new UniqueHandler($this->test_data);

        $result = $unique_handler->getUnique();

        $this->assertEqualsCanonicalizing($this->expected_data, $result);
    }

}
