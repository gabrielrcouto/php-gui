Gui\Components\LazarusObjectInterface
===============

This is the LazarusObjectInterface




* Interface name: LazarusObjectInterface
* Namespace: Gui\Components
* This is an **interface**






Methods
-------


### getLazarusObjectId

    mixed Gui\Components\LazarusObjectInterface::getLazarusObjectId()

Gets the value of lazarusObjectId.



* Visibility: **public**




### getLazarusClass

    mixed Gui\Components\LazarusObjectInterface::getLazarusClass()

Gets the value of lazarusClass.



* Visibility: **public**




### fire

    void Gui\Components\LazarusObjectInterface::fire(string $eventName)

Fire an object event



* Visibility: **public**


#### Arguments
* $eventName **string**



### on

    void Gui\Components\LazarusObjectInterface::on(string $eventName, callable $eventHandler)

Add a listener to an event



* Visibility: **public**


#### Arguments
* $eventName **string**
* $eventHandler **callable**


