<?php

namespace Gui\Exception;

/**
 * This is the Exception Class for Components
 *
 *
 * @author Johann SERVOIRE @Johann-S
 * @since 0.1
 */
class ComponentException extends \RuntimeException
{
    /**
     * ComponentException
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Activated when casting to string
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
