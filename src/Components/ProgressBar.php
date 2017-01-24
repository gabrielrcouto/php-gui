<?php

namespace Gui\Components;

/**
 * This is the ProgressBar Class
 *
 * It is a visual component for progress bar
 *
 * @author PeratX @PeratX
 * @since 0.1
 */

class ProgressBar extends VisualObject{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TProgressBar';

    public function setStep($step){
        $this->set('step', $step);

        return $this;
    }

    public function setPosition($position)
    {
        $this->set('position', $position);

        return $this;
    }

    public function getStep()
    {
        return $this->get('step');
    }

    public function getPosition()
    {
        return $this->get('position');
    }
}