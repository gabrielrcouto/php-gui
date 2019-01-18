Gui\Application
===============

This is the Application Class

This class is used to manipulate the application


* Class name: Application
* Namespace: Gui





Properties
----------


### $defaultApplication

    public \Gui\Application $defaultApplication

The application object



* Visibility: **public**
* This property is **static**.


### $eventHandlers

    protected array $eventHandlers = array()

The internal array of all callbacks



* Visibility: **protected**


### $loop

    protected \React\EventLoop\LoopInterface $loop

The application loop



* Visibility: **protected**


### $objectId

    protected integer $objectId

The next object ID available



* Visibility: **protected**


### $objects

    protected array $objects = array()

The internal array of all Components Objects in this application



* Visibility: **protected**


### $process

    public \React\ChildProcess\Process $process

The object responsible to manage the lazarus process



* Visibility: **public**


### $running

    protected boolean $running = false

Defines if the application is running



* Visibility: **protected**


### $sender

    protected \Gui\Ipc\Sender $sender

The responsible object to sent the communication messages



* Visibility: **protected**


### $receiver

    protected \Gui\Ipc\Receiver $receiver

The responsible object to receive the communication messages



* Visibility: **protected**


### $verboseLevel

    protected integer $verboseLevel = 2

The verbose level



* Visibility: **protected**


### $window

    protected \Gui\Components\Window $window

The 1st Window of the Application



* Visibility: **protected**


Methods
-------


### __construct

    void Gui\Application::__construct(array $defaultAttributes, \React\EventLoop\LoopInterface $loop)

The constructor method



* Visibility: **public**


#### Arguments
* $defaultAttributes **array**
* $loop **React\EventLoop\LoopInterface**



### getWindow

    \Gui\Components\Window Gui\Application::getWindow()

Returns the 1st Window of the Application



* Visibility: **public**




### ping

    float Gui\Application::ping()

Returns the communication time between php and lazarus



* Visibility: **public**




### addObject

    void Gui\Application::addObject(\Gui\Components\AbstractObject $object)

Put a object to the internal objects array



* Visibility: **public**


#### Arguments
* $object **Gui\Components\AbstractObject**



### destroyObject

    void Gui\Application::destroyObject(\Gui\Components\AbstractObject $object)

Destroy a object



* Visibility: **public**


#### Arguments
* $object **Gui\Components\AbstractObject**



### fire

    void Gui\Application::fire(string $eventName)

Fire an application event



* Visibility: **public**


#### Arguments
* $eventName **string**



### getNextObjectId

    integer Gui\Application::getNextObjectId()

Returns the next avaible object ID



* Visibility: **public**




### getObject

    Object Gui\Application::getObject(integer $id)

Get a object from the internal objects array



* Visibility: **public**


#### Arguments
* $id **integer**



### getVerboseLevel

    integer Gui\Application::getVerboseLevel()

Returns the verbose level



* Visibility: **public**




### on

    void Gui\Application::on(string $eventName, callable $eventHandler)

Returns the next avaible object ID



* Visibility: **public**


#### Arguments
* $eventName **string**
* $eventHandler **callable**



### run

    void Gui\Application::run()

Runs the application



* Visibility: **public**




### terminate

    void Gui\Application::terminate()

Terminates the application



* Visibility: **public**




### sendCommand

    void Gui\Application::sendCommand(string $method, array $params, callable $callback)

Send a command



* Visibility: **public**


#### Arguments
* $method **string**
* $params **array**
* $callback **callable**



### sendEvent

    void Gui\Application::sendEvent(string $method, array $params)

Send an event



* Visibility: **public**


#### Arguments
* $method **string**
* $params **array**



### setVerboseLevel

    void Gui\Application::setVerboseLevel(integer $verboseLevel)

Set the verbose level



* Visibility: **public**


#### Arguments
* $verboseLevel **integer**



### waitCommand

    mixed Gui\Application::waitCommand(string $method, array $params)

Send a command and wait the return



* Visibility: **public**


#### Arguments
* $method **string**
* $params **array**



### getLoop

    \React\EventLoop\LoopInterface Gui\Application::getLoop()

Get the event loop



* Visibility: **public**




### alert

    void Gui\Application::alert(mixed $message, string $title)

Shows an alert dialog



* Visibility: **public**


#### Arguments
* $message **mixed**
* $title **string**



### __unset

    void Gui\Application::__unset($objectId)

Unset the object referency from the stack



* Visibility: **public**


#### Arguments
* $objectId **mixed**



### isRunning

    boolean Gui\Application::isRunning()

Gets the Defines if the application is running.



* Visibility: **public**



