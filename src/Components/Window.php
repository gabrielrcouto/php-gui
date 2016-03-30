<?php

namespace Gui\Components;

/**
 * Window
 */
class Window extends Object
{
    protected $lazarusClass = 'TForm1';

    /**
     * @param String $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->set('caption', $title);

        return $this;
    }

    /**
     * @return String
     */
    public function getTitle()
    {
        return $this->get('caption');
    }
}
