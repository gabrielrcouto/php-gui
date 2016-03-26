<?php

namespace Gui\Components;

/**
 * Button
 */
class Button extends Object
{
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
     * @return self
     */
    public function setValue($value)
    {
        $this->set('caption', $value);

        return $this;
    }
}
