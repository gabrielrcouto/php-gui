<?php

namespace Test\Ipc;

use Gui\Ipc\CommandMessage;

class EventMessageTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $method = 'method';
        $params = ['param1' => 'param1'];
        $foo = 0;
        $event = new CommandMessage(
            $method,
            $params
        );

        $this->assertEquals($event->method, $method);
        $this->assertEquals($event->params, $params);
        $this->assertInstanceOf('Gui\Ipc\MessageInterface', $event);
    }
}
