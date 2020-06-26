<?php

use PHPUnit\Framework\TestCase;
use SmartTest\ArgsHandler;
use SmartTest\FileHandler;

require_once 'vendor/autoload.php';

class ArgsHandlerTest extends TestCase
{

    /**
     * @dataProvider validateArgsProvider
     */
    public function testValidateArgs($args, $expected): void
    {
        $args_handler = new ArgsHandler($args);

        if ($expected !== true) {
            $this->expectExceptionMessage($expected);
        }

        $result = $args_handler->validateArgs();

        $this->assertEquals($result, $args[1]);
    }

    public function validateArgsProvider()
    {
        return [

            [['script.php', 'logs/ok.log'], true],
            [['script.php', ''], 'No file provided'],
            [['script.php'], 'No file provided'],
            [['script.php', 'logs/ne.log'], 'logs/ne.log file not exists'],

        ];
    }
}
