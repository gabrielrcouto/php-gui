<?php

namespace Test\Components;

use Gui\Application;
use Gui\Components\Window;
use PHPUnit\Framework\TestCase;

class ObjectTest extends TestCase
{
    public function testMagicCall()
    {
        $mock = $this->getMockForAbstractClass(
            'Gui\Components\AbstractObject',
            [
                [],
                null,
                new Application()
            ]
        );

        $mock->expects($this->any())
            ->method('__call');


        $mock->setFoo(1);
        $this->assertEquals(1, $mock->getFoo());
    }

    public function testOnAndFire()
    {
        $appMock = $this->getMockBuilder('Gui\Application')
            ->setMethods(['sendCommand'])
            ->getMock();

        $appMock->expects($this->any())
            ->method('sendCommand');

        $mock = $this->getMockForAbstractClass(
            'Gui\Components\AbstractObject',
            [
                [],
                null,
                $appMock
            ]
        );

        $bar = 0;
        $mock->on('foo', function () use (&$bar) {
            $bar++;
        });

        $mock->fire('onfoo');

        $this->assertEquals(1, $bar);
    }

    public function testGetLazarusClass()
    {
        $mock = $this->getMockForAbstractClass(
            'Gui\Components\AbstractObject',
            [
                [],
                null,
                new Application
            ]
        );

        $this->assertEquals('TObject', $mock->getLazarusClass());
    }

    public function testGetLazarusObjectId()
    {
        $mock = $this->getMockForAbstractClass(
            'Gui\Components\AbstractObject',
            [
                [],
                null,
                new Application
            ]
        );

        $this->assertEquals(1, $mock->getLazarusObjectId());
    }
}
