<?php

namespace Gui\Ipc;

/**
 * This is the EventMessage Class
 *
 * This class is used as a EventMessage object
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class EventMessage implements MessageInterface
{
    /**
     * The event method
     *
     * @var string $method
     */
    public $method;

    /**
     * The command params
     *
     * @var array $params
     */
    public $params;

    /**
     * The constructor method
     *
     * @param string $method
     * @param array $params
     *
     * @return void
     */
    public function __construct($method, array $params)
    {
        $this->method = $method;
        $this->params = $params;
    }
}
