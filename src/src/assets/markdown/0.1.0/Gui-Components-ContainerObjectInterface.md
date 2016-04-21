Gui\Components\ContainerObjectInterface
===============

This is the ContainerObjectInterface




* Interface name: ContainerObjectInterface
* Namespace: Gui\Components
* This is an **interface**
* This interface extends: Gui\Components\LazarusObjectInterface





Methods
-------


### appendChild

    void Gui\Components\ContainerObjectInterface::appendChild(\Gui\Components\VisualObjectInterface $object)

Append object as child



* Visibility: **public**


#### Arguments
* $object **Gui\Components\VisualObjectInterface**



### getChild

    \Gui\Components\VisualObjectInterface Gui\Components\ContainerObjectInterface::getChild(integer $lazarusObjectId)

Get child



* Visibility: **public**


#### Arguments
* $lazarusObjectId **integer**



### getChildren

    array Gui\Components\ContainerObjectInterface::getChildren()

Get children array



* Visibility: **public**




### getLazarusObjectId

    mixed Gui\Components\LazarusObjectInterface::getLazarusObjectId()

Gets the value of lazarusObjectId.



* Visibility: **public**
* This method is defined by Gui\Components\LazarusObjectInterface




### getLazarusClass

    mixed Gui\Components\LazarusObjectInterface::getLazarusClass()

Gets the value of lazarusClass.



* Visibility: **public**
* This method is defined by Gui\Components\LazarusObjectInterface




### fire

    void Gui\Components\LazarusObjectInterface::fire(string $eventName)

Fire an object event



* Visibility: **public**
* This method is defined by Gui\Components\LazarusObjectInterface


#### Arguments
* $eventName **string**



### on

    void Gui\Components\LazarusObjectInterface::on(string $eventName, callable $eventHandler)

Add a listener to an event



* Visibility: **public**
* This method is defined by Gui\Components\LazarusObjectInterface


#### Arguments
* $eventName **string**
* $eventHandler **callable**


