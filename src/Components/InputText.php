<?php

namespace Gui\Components;

/**
 * This is the InputText Class
 *
 * It is a visual component for inputText
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class InputText extends Object
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
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
