<?php

namespace Gui\Ipc;

class CommandMessage implements MessageInterface
{
    public $callback;
    public $id;
    public $method;
    public $params;

    public function __construct($method, $params, $callback)
    {
        $this->method = $method;
        $this->params = $params;
        $this->callback = $callback;
    }
}