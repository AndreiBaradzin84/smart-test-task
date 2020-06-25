<?php

use PHPUnit\Framework\TestCase;
use SmartTest\OutputHandler;

require_once 'vendor/autoload.php';

class OutputHandlerTest extends TestCase
{

    public function testDisplayResult()
    {
        $data = ['all' => ['/home' => '2'], 'unique' => ['/home' => '2']];

        $this->expectOutputString("\nTop page visits - all\n\n/home visited 2 times\n\nTop page visits - unique\n\n/home visited 2 times\n");
        $outputHandler = new OutputHandler($data);
        $outputHandler->displayResult();

    }
}
