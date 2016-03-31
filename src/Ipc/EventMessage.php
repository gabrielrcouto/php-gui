<?php

namespace Gui\Ipc;

class EventMessage implements MessageInterface
{
    public $method;
    public $params;

    public function __construct($method, $params)
    {
        $this->method = $method;
        $this->params = $params;
    }
}
