<?php

namespace Gui\Components;

/**
 * This is the Label Class
 *
 * It is a visual component for label
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class Label extends Object
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
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
     * @param string $value
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
