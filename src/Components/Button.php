<?php

namespace Gui\Components;

/**
 * This is the Button Class
 *
 * It is a visual component for button
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class Button extends VisualObject
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TButton';

    /**
     * Get the Button value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->get('caption');
    }

    /**
     * Set the Button Value
     *
     * @param string $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->set('caption', $value);

        return $this;
    }
}
