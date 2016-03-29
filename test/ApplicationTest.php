<?php

namespace Test;

use Gui\Application;

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
}
