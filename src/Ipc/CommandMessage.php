<?php

namespace Gui\Ipc;

class CommandMessage implements MessageInterface
{
    public $id;
    public $method;
    public $params;

    public function __construct($method, $params)
    {
        $this->method = $method;
        $this->params = $params;
    }
}