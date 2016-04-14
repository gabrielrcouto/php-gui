<?php

namespace Test;

use Gui\Color;

class ColorTest extends \PHPUnit_Framework_TestCase
{
    public function testColorToLazarus()
    {
        $lazarusColor = Color::toLazarus('#112233');

        $this->assertTrue(is_int($lazarusColor));
        $this->assertEquals(3351057, $lazarusColor);

        $lazarusColor = Color::toLazarus('112233');
        $this->assertTrue(is_int($lazarusColor));
        $this->assertEquals(3351057, $lazarusColor);
    }
}
