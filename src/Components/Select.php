<?php

namespace Gui\Components;

/**
 * It is a visual component for select
 *
 * @author Rafael Reis @reisraff
 * @since 0.1
 */
class Select extends VisualObject
{
    /**
     * The lazarus class as string.
     *
     * @var string
     */
    protected $lazarusClass = 'TComboBox';

    /**
     * Sets the options.
     *
     * @return self
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $option) {
            if (!$option instanceof Option) {
                // @todo: throw an exception
                unset($option[$key]);
            } else {
                $this->call(
                    'items.addObject',
                    [
                        $option->getLabel(),
                        $option->getValue(),
                    ]
                );
            }
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

    /**
     * Set if is read only.
     *
     * @param bool
     * @param mixed $val
     *
     * @return self
     */
    public function setReadOnly($val)
    {
        $this->set('readOnly', $val);

        return $this;
    }
}
