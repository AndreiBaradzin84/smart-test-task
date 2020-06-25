<?php

use PHPUnit\Framework\TestCase;

require_once 'classes/DataHandler.php';

class DataHandlerTest extends TestCase {

    protected $test_data;
    protected $class_reflection;

    protected function setUp(): void {

        $this->test_data = [
            [ '/home', '192.168.1.1' ],
            [ '/home', '192.168.1.1' ],
            [ '/help', '192.168.1.1' ],
            [ '/help', '192.168.1.2' ],
            [ '/help', '192.168.1.2' ]
        ];

        $this->class_reflection = new ReflectionClass( 'DataHandler' );
    }

    public function testGetStats(): void {

        $expected = [
            'all'    => [ '/help' => 3, '/home' => 2 ],
            'unique' => [ '/help' => 2, '/home' => 1 ],
        ];

        $data_handler = new DataHandler( $this->test_data );

        $this->assertEquals( $data_handler->getStats(), $expected );
    }

    public function testGetUnique(): void {

        $expected = [
            [ '/home', '192.168.1.1' ],
            [ '/help', '192.168.1.1' ],
            [ '/help', '192.168.1.2' ]
        ];

        $method = $this->class_reflection->getMethod( 'getUnique' );
        $method->setAccessible( true );

        $data_handler = new DataHandler( $this->test_data );

        $result = $method->invoke( $data_handler, $this->test_data );

        $this->assertEqualsCanonicalizing( $expected, $result );
    }

    public function testCountArray(): void {

        $expected = [ '/home' => 2, '/help' => 3 ];

        $method = $this->class_reflection->getMethod( 'countArray' );
        $method->setAccessible( true );

        $data_handler = new DataHandler( $this->test_data );

        $result = $method->invoke( $data_handler, $this->test_data );

        $this->assertEquals( $expected, $result );
    }

}
