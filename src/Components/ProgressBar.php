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

class ProgressBar extends VisualObject
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TProgressBar';

    public function setStep($step)
    {
        $this->set('step', $step);

        return $this;
    }

    public function getStep()
    {
        return $this->get('step');
    }

    public function setPosition($position)
    {
        $this->set('position', $position);

        return $this;
    }

    public function getPosition()
    {
        return $this->get('position');
    }

    public function setMax($max)
    {
        $this->set('max', $max);

        return $this;
    }

    public function getMax()
    {
        return $this->get('max');
    }

    public function setMin($min)
    {
        $this->set('min', $min);

        return $this;
    }

    public function getMin()
    {
        return $this->get('min');
    }
}
