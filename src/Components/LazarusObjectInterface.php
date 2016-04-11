<?php

namespace Gui\Components;

/**
 * This is the LazarusObjectInterface
 *
 * @author Rodrigo Azevedo @rodrigowbazeved
 * @since 0.1
 */
interface LazarusObjectInterface
{
    /**
     * Gets the value of lazarusObjectId.
     *
     * @return mixed
     */
    public function getLazarusObjectId();

    /**
     * Gets the value of lazarusClass.
     *
     * @return mixed
     */
    public function getLazarusClass();

    /**
     * Fire an object event
     *
     * @param string $eventName Event Name
     *
     * @return void
     */
    public function fire($eventName);

    /**
     * Add a listener to an event
     *
     * @param string $eventName Event Name
     * @param callable $eventHandler Event Handler Function
     *
     * @return void
     */
    public function on($eventName, callable $eventHandler);
}
