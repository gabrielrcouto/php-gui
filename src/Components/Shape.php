<?php

namespace Gui\Components;

use Gui\Color;

/**
 * Shape
 */
class Shape extends Object
{
    protected $lazarusClass = 'TShape';

    /**
     * Get the background color
     *
     * @return String
     */
    public function getBackgroundColor()
    {
        return $this->get('brush.color');
    }

    /**
     * Set the background Color
     *
     * @param String $color Color '#123456'
     * @return self
     */
    public function setBackgroundColor($color)
    {
        $this->set('brush.color', Color::toLazarus($color));

        return $this;
    }

    /**
     * Get the border color
     *
     * @return String
     */
    public function getBorderColor()
    {
        return $this->get('pen.color');
    }

    /**
     * Set the border Color
     *
     * @param String $color Color '#123456'
     * @return self
     */
    public function setBorderColor($color)
    {
        $this->set('pen.color', Color::toLazarus($color));

        return $this;
    }
}
