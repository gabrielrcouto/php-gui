<?php

namespace Gui\Components;

trait ParentObjectTrait
{
    protected $children = [];

    public function appendChild(LazarusObjectInterface $object)
    {
        $this->children[$object->getLazarusObjectId()] = $object;
    }

    public function getChild($lazarusObjectId)
    {
        if(!isset($this->children[$lazarusObjectId])){
            throw new \Exception("Child object not found");
        }

        return $this->children[$lazarusObjectId];
    }

    public function getChildren()
    {
        return $this->children;
    }
}
