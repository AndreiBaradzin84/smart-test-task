<?php

use PHPUnit\Framework\TestCase;
use SmartTest\FileHandler;

require_once 'vendor/autoload.php';

class FileHandlerTest extends TestCase
{

    protected $filename;
    protected $class_reflection;

    protected function setUp(): void
    {
        $this->filename = 'logs/ok.log';
        $this->class_reflection = new ReflectionClass('SmartTest\FileHandler');
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testGetData($filename, $expected): void
    {
        $file_handler = new FileHandler($filename);

        if ($expected === null) {
            $this->expectExceptionMessage('No valid data in logfile');
        }

        $this->assertEquals($file_handler->getData(), $expected);
    }

    public function getDataProvider()
    {
        return [

            [
                'logs/ok.log',
                [
                    ['/home', '192.168.1.1'],
                    ['/home', '192.168.1.1'],
                    ['/help', '192.168.1.1'],
                    ['/help', '192.168.1.2'],
                    ['/help', '192.168.1.2'],
                ]
            ],
            [
                'logs/corrupted.log',
                null
            ],
        ];
    }

    /**
     * @dataProvider checkDataPairProvider
     */
    public function testCheckDataPair($pair, $expected): void
    {
        $method = $this->class_reflection->getMethod('checkDataPair');
        $method->setAccessible(true);

        $file_handler = new FileHandler($this->filename);

        $result = $method->invoke($file_handler, $pair);

        $this->assertEquals($result, $expected);
    }

    public function checkDataPairProvider()
    {
        return [

            [['/home', '192.168.1.1'], true],
            [['/home', ''], false],
            [['/home', 'justastring'], false],

        ];
    }

    /**
     * @dataProvider validateFileSizeProvider
     */
    public function testValidateFileSize($filesize, $expected): void
    {
        $method = $this->class_reflection->getMethod('validateFileSize');
        $method->setAccessible(true);

        $file_handler = new FileHandler($this->filename);

        $result = $method->invoke($file_handler, $filesize);

        $this->assertEquals($result, $expected);
    }

    public function validateFileSizeProvider()
    {
        $memory_limit = ini_get('memory_limit');

        if ($memory_limit != -1) {

            preg_match("@[kmg]@i", $memory_limit, $letter);

            if ( ! empty($letter)) {

                $letter = strtolower($letter[0]);
                $memory_limit = (int)$memory_limit;
                switch ($letter) {
                    case 'k' :
                        {
                            $memory_limit = $memory_limit * 1024;
                            break;
                        }
                    case 'm' :
                        {
                            $memory_limit = $memory_limit * 1024 ** 2;
                            break;
                        }
                    case 'g' :
                        {
                            $memory_limit = $memory_limit * 1024 ** 3;
                            break;
                        }
                }
            }

            return [

                [$memory_limit * 0.7, true],
                [$memory_limit * 0.5, true],
                [$memory_limit * 0.8, false],

            ];
        }
    }
}
