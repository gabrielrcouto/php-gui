<?php

namespace Gui\Components;

use Gui\Color;

/**
 * This is the Shape Class
 *
 * It is a visual component for shape
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class Shape extends VisualObject
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
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
     * @param string $color Color '#123456'
     *
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
     * @param string $color Color '#123456'
     *
     * @return self
     */
    public function setBorderColor($color)
    {
        $this->set('pen.color', Color::toLazarus($color));

        return $this;
    }
}
