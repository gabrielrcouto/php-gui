<?php

namespace Gui\Components;

interface LazarusObjectInterface
{
    public function getLazarusObjectId();
    public function getLazarusClass();
    public function fire($eventName);
    public function on($eventName, callable $eventHandler);
}
