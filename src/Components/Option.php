<?php

namespace Gui\Components;

/**
 * @author Alex Silva
 * @since 0.1
 */
class Option
{
    /**
     * The label for the option.
     *
     * @var string
     */
    private $label;

    /**
     * The value for the option.
     *
     * @var int
     */
    private $value;

    public function __construct($label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * This method is used to set an string label for the object instance.
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * This method is used to set an integer value for the object instance.
     *
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * This method returns the instance Label.
     *
     * @return string
     */
    public function getLabel()
    {
        return (string) $this->label;
    }

    /**
     * This method returns the instance value.
     *
     * @return int
     */
    public function getValue()
    {
        return (int) $this->value;
    }
}
