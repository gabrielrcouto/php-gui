<?php

namespace Gui\Components;

/**
 * Label
 */
class Label extends Object
{
    protected $lazarusClass = 'TLabel';

    /**
     * Get the Label text
     *
     * @return mixed
     */
    public function getText()
    {
        return $this->get('caption');
    }

    /**
     * Set the Label text
     *
     * @return self
     */
    public function setText($value)
    {
        $this->set('caption', $value);

        return $this;
    }
}
