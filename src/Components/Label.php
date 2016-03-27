<?php

namespace Gui\Components;

/**
 * Label
 */
class Label extends Object
{
    protected $lazarusClass = 'TLabel';

    /**
     * Get the Label text
     *
     * @return mixed
     */
    public function getText()
    {
        return $this->get('caption');
    }

    /**
     * Set the Label text
     *
     * @param String $value
     *
     * @return self
     */
    public function setText($value)
    {
        $this->set('caption', $value);

        return $this;
    }

    /**
     * Get the font size
     *
     * @return float
     */
    public function getFontSize()
    {
        return $this->get('font.size');
    }

    /**
     * Set the font size for label
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
}
