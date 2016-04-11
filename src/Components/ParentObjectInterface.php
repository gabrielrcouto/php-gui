<?php

namespace Gui\Components;

interface ParentObjectInterface extends LazarusObjectInterface
{
    public function appendChild(Object $object);
    public function getChild($lazarusObjectId);
    public function getChildren();
}
