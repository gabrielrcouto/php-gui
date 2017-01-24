<?php

namespace Test;

use Gui\Application;
use Gui\Ipc\IpcMap;
use Gui\Components\Window;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetNextObjectId()
    {
        $application = new Application();

        // zero is for the object window
        $this->assertEquals(1, $application->getNextObjectId());
        $this->assertEquals(2, $application->getNextObjectId());
        $this->assertEquals(3, $application->getNextObjectId());
    }

    public function testGetWindow()
    {
        $application = new Application();

        $this->assertInstanceOf('Gui\Components\Window', $application->getWindow());
    }

    public function testGetLoop()
    {
        $application = new Application();

        $this->assertInstanceOf('React\EventLoop\LoopInterface', $application->getLoop());
    }

    public function testPing()
    {
        $mock = $this->getMockBuilder('Gui\Application')
            ->setMethods(['waitMessage'])
            ->getMock();

        $mock->expects($this->once())
            ->method('waitMessage')
            ->willReturn(null);

        $this->assertTrue(is_float($mock->ping()));
    }

    public function testAddObject()
    {
        $application = new Application();

        $this->assertNull($application->getObject(1));

        $application->addObject(new Window([], null, $application));

        $this->assertInstanceOf('Gui\Components\Window', $application->getObject(1));
    }

    public function testOnAndFire()
    {
        $application = new Application();

        $bar = 0;
        $application->on('foo', function () use (&$bar) {
            $bar++;
        });

        $application->fire('foo');

        $this->assertEquals(1, $bar);
    }

    public function testGetAndSetVerboseLevel()
    {
        $application = new Application();

        $this->assertEquals(2, $application->getVerboseLevel());
        $application->setVerboseLevel(1);
        $this->assertEquals(1, $application->getVerboseLevel());
    }

    public function testDestroyObject()
    {
        $appMock = $this->getMockBuilder('Gui\Application')
            ->setMethods(['getWindow', 'sendMessage'])
            ->getMock();

        $window = $this->getMockBuilder(
            'Gui\Components\Window',
            [
                [],
                null,
                $appMock
            ]
        )
            ->disableOriginalConstructor()
            ->getMock();

        $appMock->expects($this->any())
            ->method('getWindow')
            ->will($this->returnValue($window));

        $mock = $this->getMockForAbstractClass(
            'Gui\Components\Object',
            [
                [],
                null,
                $appMock
            ]
        );

        $appMock->expects($this->once())
            ->method('sendMessage')
            ->with(
                [
                    IpcMap::ROOT_METHOD_ID_KEY => IpcMap::COMMAND_METHOD_DESTROY_OBJECT,
                    IpcMap::ROOT_PARAMS_KEY => [
                        IpcMap::PARAMS_OBJECT_ID_KEY => $mock->getLazarusObjectId()
                    ]
                ],
                function () {
                }
            );

        $appMock->destroyObject($mock);
    }
}
