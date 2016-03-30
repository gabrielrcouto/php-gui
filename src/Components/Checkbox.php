<?php

namespace Gui\Components;

/**
 * Checkbox
 */
class Checkbox extends Object
{
    protected $lazarusClass = 'TCheckBox';

    /**
     * Get the Checkbox checked
     *
     * @return mixed
     */
    public function getChecked()
    {
        return $this->get('checked');
    }

    /**
     * Set the Checkbox Checked
     *
     * @return self
     */
    public function setChecked($checked)
    {
        $this->set('checked', $checked);

        return $this;
    }
}
