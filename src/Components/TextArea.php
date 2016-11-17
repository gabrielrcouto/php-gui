<?php

namespace Gui\Components;

use Gui\Ipc\IpcMap;

/**
 * This is the TextArea Class
 *
 * It is a visual component for textarea
 *
 * @author Rafael Reis @reisraff
 * @since 0.1
 */
class TextArea extends VisualObject
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 11;

    /**
     * Sets the value of value.
     *
     * @param string $value the value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->call(IpcMap::OBJECT_METHOD_LINES_CLEAR);

        foreach (explode("\n", $value) as $value) {
            $this->call(
                IpcMap::OBJECT_METHOD_LINES_ADD,
                [
                    IpcMap::PARAMS_DATA => $value
                ]
            );
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
        return $this->application->waitMessage([
            IpcMap::ROOT_METHOD_ID_KEY => IpcMap::COMMAND_METHOD_CALL_OBJECT_METHOD,
            IpcMap::ROOT_PARAMS_KEY => [
                IpcMap::PARAMS_OBJECT_ID_KEY => $this->getLazarusObjectId(),
                IpcMap::PARAMS_OBJECT_METHOD_NAME_KEY => IpcMap::OBJECT_METHOD_LINES_GET_ALL
            ],
        ]);
    }
}
