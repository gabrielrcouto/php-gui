<?php

namespace Gui\Components;

use Gui\Application;

/**
 * This is the Item class
 *
 * @author Alex Silva
 * @since 0.1
 */
class Item
{
    /**
     *
     * @var string $label
     */
    private $label;

    /**
     *
     * @var int $id
     */
    private $id;

    public function __construct($label, $id)
    {
        $this->label = $label;
        $this->id = $id;
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
     * This method is used to set an integer id for the object instance
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * This method returns the instance id
     *
     * @return integer
     */
    public function getId()
    {
        return (int) $this->id;
    }
}
