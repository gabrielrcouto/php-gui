<?php

namespace Gui\Components;

use Gui\Ipc\IpcMap;

/**
 * This is the Radio Class
 *
 * It is a visual component for radio
 *
 * @author Rafael Reis @reisraff
 * @since 0.1
 */
class Radio extends VisualObject
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 8;

    /**
     * Sets the options
     *
     * @param array $options
     *
     * @return self
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $option) {
            if (! $option instanceof Option) {
                throw new \InvalidArgumentException('Element in array options must be an instance of Option');
            } else {
                $this->call(
                    IpcMap::OBJECT_METHOD_ITEMS_ADD_OBJECT,
                    [
                        IpcMap::PARAMS_DATA => $option->getLabel(),
                        IpcMap::PARAMS_DATA1 => $option->getValue()
                    ]
                );
            }
        }

        return $this;
    }

    /**
     * Gets the checked item id
     *
     * @return int
     */
    public function getChecked()
    {
        return $this->get('itemIndex');
    }
}
