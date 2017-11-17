<?php

namespace Test\Ipc;

use Gui\Application;
use Gui\Ipc\Receiver;
use Gui\Ipc\Sender;
use PHPUnit\Framework\TestCase;

class SenderTest extends TestCase
{
    public function testConstructor()
    {
        $application = new Application();
        $receiver = new Receiver($application);

        $sender = new Sender($application, $receiver);

        $this->assertInstanceOf('Gui\Application', $sender->application);
        $this->assertInstanceOf('Gui\Ipc\Receiver', $sender->receiver);
    }
}
