<?php

namespace Gui\Components;

/**
 * Input Text
 */
class InputText extends Object
{
    protected $lazarusClass = 'TEdit';

    /**
     * Sets the value of value.
     *
     * @param string $value the value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->set('text', $value);

        return $this;
    }

    /**
     * Gets the value of value;
     *
     * @return string
     */
    public function getValue()
    {
        return $this->get('text');
    }
}
