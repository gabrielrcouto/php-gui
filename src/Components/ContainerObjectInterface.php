<?php

namespace Gui\Components;

/**
 * This is the ContainerObjectInterface
 *
 * @author Rodrigo Azevedo @rodrigowbazeved
 * @since 0.1
 */
interface ContainerObjectInterface extends LazarusObjectInterface
{
    /**
     * Append object as child
     *
     * @param VisualObjectInterface $object
     *
     * @return void
     */
    public function appendChild(VisualObjectInterface  $object);

    /**
     * Get child
     *
     * @param int $lazarusObjectId the object id
     *
     * @return VisualObjectInterface
     */
    public function getChild($lazarusObjectId);

    /**
     * Get children array
     *
     * @return array
     */
    public function getChildren();
}
