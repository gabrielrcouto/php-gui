<?php

namespace Gui\Components;

use Gui\Color;

/**
 * This is the Select Class
 *
 * It is a visual component for select
 *
 * @author Rafael Reis @reisraff
 * @since 0.1
 */
class Select extends VisualObject
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TComboBox';

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
            if (! $item instanceof item) {
                // @todo: throw an exception
                unset($item[$key]);
            } else {
                $this->call(
                    'items.addObject',
                    [
                        $item->getLabel(),
                        $item->getId()
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

    /**
     * Set if is read only
     *
     * @param bool
     *
     * @return self
     */
    public function setReadOnly($val)
    {
        $this->set('readOnly', $val);

        return $this;
    }
}
