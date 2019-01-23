<?php

namespace Test\Components;

use Gui\Application;
use Gui\Components\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testMissingFile()
    {
        $this->setExpectedException(
            \Exception::class,
            'The file could not be found.'
        );
        
        $image = new Image([], null, new Application());
        $image->setFile('this-image-does-not-exist.png');
    }
}
