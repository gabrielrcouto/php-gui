<?php

namespace Gui\Components;

interface ParentObjectInterface extends LazarusObjectInterface
{
    public function appendChild(LazarusObjectInterface $object);
    public function getChild($lazarusObjectId);
    public function getChildren();
}
