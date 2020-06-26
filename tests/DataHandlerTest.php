<?php

use PHPUnit\Framework\TestCase;
use SmartTest\DataHandler;

require_once 'vendor/autoload.php';

class DataHandlerTest extends TestCase
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
        $this->expected_data = ['/home' => 2, '/help' => 3];
    }



    public function testCountArray(): void
    {
        $data_handler = new DataHandler;
        $result = $data_handler->countArray($this->test_data);
        $this->assertEquals($this->expected_data, $result);
    }

}
