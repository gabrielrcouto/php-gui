<?php

namespace Test;

use Gui\Color;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
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

    /**
     * @expectedException InvalidArgumentException
     */
    public function testShouldThrowExceptionWithInvalidHexColor()
    {
        $lazarusColor = Color::toLazarus('#11AAGG');
    }
}
