<?php

namespace Test\Ipc;

use Gui\Application;
use Gui\Ipc\Receiver;

class ReceiverTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $receiver = new Receiver(new Application());

        $this->assertInstanceOf('Gui\Application', $receiver->application);
    }

    public function testAddMessageCallback()
    {
        $receiver = new Receiver(new Application());

        $foo = 0;
        $receiver->addMessageCallback(
            1,
            function () use (&$foo) {
                $foo++;
            }
        );

        $this->assertTrue(is_array($receiver->messageCallbacks));
        $receiver->messageCallbacks[1]();
        $this->assertEquals(1, $foo);
    }

    public function testCallObjectEventListener()
    {
        $application = new Application();

        $obj = $this->getMockBuilder('Gui\Components\Window')
            ->setConstructorArgs([[], null, $application])
            ->setMethods(['fire'])
            ->getMock();

        $obj->expects($this->once())
            ->method('fire')
            ->with('foo');

        $application->addObject($obj);

        $receiver = new Receiver($application);

        $receiver->callObjectEventListener(1, 'foo');
    }

    public function testCallMessageCallback()
    {
        $receiver = new Receiver(new Application());

        $foo = null;
        $receiver->addMessageCallback(
            1,
            function ($result) use (&$foo) {
                $foo = $result;
            }
        );

        $receiver->callMessageCallback(1, 1);
        $this->assertEquals(1, $foo);
    }
}
