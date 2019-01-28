<?php

namespace Gui\Components;

/**
 * It is a visual component for button
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class Button extends VisualObject
{
    /**
     * The lazarus class as string.
     *
     * @var string
     */
    protected $lazarusClass = 'TButton';

    /**
     * Get the Button value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->get('caption');
    }

    /**
     * Set the Button Value.
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
