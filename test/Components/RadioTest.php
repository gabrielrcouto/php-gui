<?php

namespace Test\Components;

use Gui\Application;
use Gui\Components\Option;
use Gui\Components\Radio;

class RadioTest extends \PHPUnit_Framework_TestCase
{

    public function testSetOptions()
    {
        $radio = new Radio([], null, new Application());

        $this->assertSame($radio, $radio->setOptions([new Option('foo', 1)]));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowExceptionWithSetOptionsInvalidIntegerArgument()
    {
        $radio = new Radio([], null, new Application());

        $radio->setOptions([1]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowExceptionWithSetOptionsInvalidArgument()
    {
        $radio = new Radio([], null, new Application());

        $radio->setOptions(['foo' => 'bar']);
    }
}
