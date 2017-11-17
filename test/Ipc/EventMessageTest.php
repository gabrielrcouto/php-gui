<?php

namespace Test\Ipc;

use Gui\Ipc\CommandMessage;
use PHPUnit\Framework\TestCase;

class EventMessageTest extends TestCase
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
