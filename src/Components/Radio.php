<?php

namespace Gui\Components;

/**
 * It is a visual component for radio
 *
 * @author Rafael Reis @reisraff
 * @since 0.1
 */
class Radio extends VisualObject
{
    /**
     * The lazarus class as string.
     *
     * @var string
     */
    protected $lazarusClass = 'TRadioGroup';

    /**
     * Sets the options.
     *
     * @return self
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $option) {
            if (!$option instanceof Option) {
                throw new \InvalidArgumentException('Element in array options must be an instance of Option');
            }
            $this->call(
                    'items.addObject',
                    [
                        $option->getLabel(),
                        $option->getValue(),
                    ]
                );
        }

        return $this;
    }

    /**
     * Gets the checked item id.
     *
     * @return int
     */
    public function getChecked()
    {
        return $this->get('itemIndex');
    }
}
