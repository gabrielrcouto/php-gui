<?php

namespace Gui\Components;

/**
 * This is the Radio Class
 *
 * It is a visual component for radio
 *
 * @author Rafael Reis @reisraff
 * @since 0.1
 */
class Radio extends Object
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TRadioGroup';

    /**
     * Sets the items
     *
     * @param array $items
     *
     * @return self
     */
    public function setItems(array $items)
    {
        foreach ($items as $key => $item) {
            if (! is_string($item[0]) || ! is_int($item[1])) {
                // @todo: throw an exception
                unset($item[$key]);
            } else {
                $this->call(
                    'items.addObject',
                    [
                        $item[0],
                        $item[1]
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
