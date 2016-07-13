<?php

namespace Gui\Components;

use Gui\Application;

/**
 * This is the Option class
 *
 * @author Alex Silva
 * @since 0.1
 */
class Option
{
    /**
     * The label for the option
     *
     * @var string $label
     */
    private $label;

    /**
     * The value for the option
     *
     * @var int $value
     */
    private $value;

    public function __construct($label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * This method is used to set an string label for the object instance
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * This method is used to set an integer value for the object instance
     *
     * @param integer $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * This method returns the instance Label
     *
     * @return string
     */
    public function getLabel()
    {
        return (string) $this->label;
    }

    /**
     * This method returns the instance value
     *
     * @return integer
     */
    public function getValue()
    {
        return (int) $this->value;
    }
}
