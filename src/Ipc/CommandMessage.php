<?php

namespace Gui\Ipc;

/**
 * This is the CommandMessage Class
 *
 * This class is used as a CommandMessage object
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class CommandMessage implements MessageInterface
{
    /**
     * The command id
     *
     * @var int $id
     */
    public $id;

    /**
     * The command method
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
     * The command callback
     *
     * @var callable $callback
     */
    public $callback;

    /**
     * The constructor method
     *
     * @param string $method
     * @param array $params
     * @param callable $callback
     *
     * @return void
     */
    public function __construct($method, array $params, callable $callback = null)
    {
        $this->method = $method;
        $this->params = $params;
        $this->callback = $callback;
    }
}
