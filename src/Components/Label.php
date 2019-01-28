<?php

namespace Gui\Components;

use Gui\Color;

/**
 * It is a visual component for label
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class Label extends VisualObject
{
    /**
     * The lazarus class as string.
     *
     * @var string
     */
    protected $lazarusClass = 'TLabel';

    /**
     * Get the font color.
     *
     * @return string
     */
    public function getFontColor()
    {
        return $this->get('font.color');
    }

    /**
     * Set the font Color.
     *
     * @param string $color Color '#123456'
     *
     * @return self
     */
    public function setFontColor($color)
    {
        $this->set('font.color', Color::toLazarus($color));

        return $this;
    }

    /**
     * Get the font family.
     *
     * @return string
     */
    public function getFontFamily()
    {
        return $this->get('font.name');
    }

    /**
     * Set the font Family.
     *
     * @param string $family Family name (ex: Arial)
     *
     * @return self
     */
    public function setFontFamily($family)
    {
        $this->set('font.name', $family);

        return $this;
    }

    /**
     * Get the font size.
     *
     * @return float
     */
    public function getFontSize()
    {
        return $this->get('font.size');
    }

    /**
     * Set the font size for label.
     *
     * @param float $size
     *
     * @return self
     */
    public function setFontSize($size)
    {
        $this->set('font.size', $size);

        return $this;
    }

    /**
     * Get the Label text.
     *
     * @return mixed
     */
    public function getText()
    {
        return $this->get('caption');
    }

    /**
     * Set the Label text.
     *
     * @param string $value
     *
     * @return self
     */
    public function setText($value)
    {
        $this->set('caption', $value);

        return $this;
    }
}
