<?php

namespace Test\Ipc;

use Gui\Ipc\CommandMessage;
use PHPUnit\Framework\TestCase;

class CommandMessageTest extends TestCase
{
    public function testConstructor()
    {
        $method = 'method';
        $params = ['param1' => 'param1'];
        $foo = 0;
        $msg = new CommandMessage(
            $method,
            $params,
            function () use (&$foo) {
                $foo++;
            }
        );

        $this->assertEquals($msg->method, $method);
        $this->assertEquals($msg->params, $params);
        $callback = $msg->callback;
        $callback();
        $this->assertEquals(1, $foo);
        $this->assertInstanceOf('Gui\Ipc\MessageInterface', $msg);
    }
}
