<?php

namespace Gui\Components;

/**
 * This is the TextArea Class
 *
 * It is a visual component for textarea
 *
 * @author Rafael Reis @reisraff
 * @since 0.1
 */
class TextArea extends Object
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TMemo';

    /**
     * Sets the value of value.
     *
     * @param string $value the value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->call('lines.clear', []);

        foreach (explode("\n", $value) as $value) {
            $this->call('lines.add', [$value]);
        }

        return $this;
    }

    /**
     * Gets the value of value;
     *
     * @return string
     */
    public function getValue()
    {
        return $this->application->waitCommand(
            'callObjectMethod',
            [
                $this->lazarusObjectId,
                'lines.getAll',
                []
            ]
        );
    }
}
