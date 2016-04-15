<?php

namespace Gui\Components;

/**
 * This is the Checkbox Class
 *
 * It is a visual component for checkbox
 *
 * @author Rafael Reis @reisraff
 * @since 0.1
 */
class Checkbox extends VisualObject
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TCheckBox';

    /**
     * Get the Checkbox checked
     *
     * @return bool
     */
    public function getChecked()
    {
        return $this->get('checked');
    }

    /**
     * Set the Checkbox Checked
     *
     * @param bool $checked
     *
     * @return self
     */
    public function setChecked($checked)
    {
        $this->set('checked', $checked);

        return $this;
    }
}
