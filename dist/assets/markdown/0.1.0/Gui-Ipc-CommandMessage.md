Gui\Ipc\CommandMessage
===============

This is the CommandMessage Class

This class is used as a CommandMessage object


* Class name: CommandMessage
* Namespace: Gui\Ipc
* This class implements: Gui\Ipc\MessageInterface




Properties
----------


### $id

    public integer $id

The command id



* Visibility: **public**


### $method

    public string $method

The command method



* Visibility: **public**


### $params

    public array $params

The command params



* Visibility: **public**


### $callback

    public callable $callback

The command callback



* Visibility: **public**


Methods
-------


### __construct

    void Gui\Ipc\CommandMessage::__construct(string $method, array $params, callable $callback)

The constructor method



* Visibility: **public**


#### Arguments
* $method **string**
* $params **array**
* $callback **callable**


