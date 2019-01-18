<?php

namespace Gui\Components;

/**
 * It is a container component
 *
 * @author Rodrigo Azevedo @rodrigowbazeved
 * @since 0.1
 */
abstract class ContainerObject extends VisualObject implements ContainerObjectInterface
{

    /**
     * The children objetcs
     *
     * @var array $children
     */
    protected $children = [];

    /**
     * {@inheritdoc}
     */
    public function appendChild(VisualObjectInterface $object)
    {
        $this->children[$object->getLazarusObjectId()] = $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getChild($lazarusObjectId)
    {
        if (!isset($this->children[$lazarusObjectId])) {
            throw new \Exception("Child object not found");
        }

        return $this->children[$lazarusObjectId];
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }
}
