<?php

namespace Gui\Ipc;

/**
 * This class is used as a CommandMessage object
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class CommandMessage implements MessageInterface
{
    /**
     * The command id.
     *
     * @var int
     */
    public $id;

    /**
     * The command method.
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
     * The command callback.
     *
     * @var callable
     */
    public $callback;

    /**
     * The constructor method.
     *
     * @param string   $method
     * @param callable $callback
     */
    public function __construct($method, array $params, callable $callback = null)
    {
        $this->method = $method;
        $this->params = $params;
        $this->callback = $callback;
    }
}
