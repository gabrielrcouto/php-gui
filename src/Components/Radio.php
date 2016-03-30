<?php

namespace Gui\Components;

/**
 * Radio
 */
class Radio extends Object
{
    protected $lazarusClass = 'TRadioGroup';

    public function setItems(array $items)
    {
        foreach ($items as $key => $item) {
            if (! is_string($item[0]) || ! is_int($item[1])) {
                // @todo throw an exception
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
    }

    public function getChecked()
    {
        return $this->get('itemIndex');
    }
}
