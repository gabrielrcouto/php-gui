<?php

namespace Test;

use Gui\Application;
use Gui\Components\Window;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
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
            ->setMethods(['waitCommand'])
            ->getMock();

        $mock->expects($this->once())
            ->method('waitCommand')
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
            ->setMethods(['getWindow', 'sendCommand'])
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
            'Gui\Components\AbstractObject',
            [
                [],
                null,
                $appMock
            ]
        );

        $appMock->expects($this->once())
            ->method('sendCommand')
            ->with(
                'destroyObject',
                [$mock->getLazarusObjectId()],
                function () {
                }
            );

        $appMock->destroyObject($mock);
    }
}
