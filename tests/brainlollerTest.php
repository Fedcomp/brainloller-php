<?php

use Fedcomp\BrainLoller;

class BrainLollerTest extends PHPUnit_Framework_TestCase
{
    const HELLO_WORLD = '/images/hello-world.png';

    /**
     * @var \Fedcomp\BrainLoller
     */
    protected $brainloller;

    public function setUp(){
        $this->brainloller = new BrainLoller();
    }

    public function testReadHelloWorld()
    {
        $this->assertEquals(
            $this->brainloller->init(__DIR__ . self::HELLO_WORLD)->getCode(),
            '++++++[>++++++++++++<-]>.>++++++++++[>++++++++++<-]>+.+++++++..+++.>++++[>+++++++++++<-]>.<+++[>----<-]>.<<<<<+++[>+++++<-]>.>>.+++.------.--------.>>+.'
        );
    }

    /**
     * @expectedException     InvalidArgumentException
     */
    public function testEmptyOrNonExistentHandle(){
        $this->brainloller->init('');
    }

    /**
     * @expectedException     InvalidArgumentException
     */
    public function testWrongFileHandle(){
        $this->brainloller->init(fopen('data://image/png;base64,fake', 'r'))->getCode();
    }

    public function testFileHandle(){
        $this->assertEquals(
            152,
            strlen( $this->brainloller->init(fopen(__DIR__ . self::HELLO_WORLD, 'r'))->getCode() )
        );
    }

    public function testGDHandle(){
        $this->markTestIncomplete();
    }
}
