<?php

namespace Gui\Ipc;

/**
 * This class is used as a EventMessage object
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class EventMessage implements MessageInterface
{
    /**
     * The event method.
     *
     * @var string
     */
    public $method;

    /**
     * The command params.
     *
     * @var array
     */
    public $params;

    /**
     * The constructor method.
     *
     * @param string $method
     */
    public function __construct($method, array $params)
    {
        $this->method = $method;
        $this->params = $params;
    }
}
