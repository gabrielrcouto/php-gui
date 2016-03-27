<?php

namespace Test;

use Gui\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetNextObjectId()
    {
        $application = new Application();

        $this->assertEquals(0, $application->getNextObjectId());
        $this->assertEquals(1, $application->getNextObjectId());
        $this->assertEquals(2, $application->getNextObjectId());
    }
}
