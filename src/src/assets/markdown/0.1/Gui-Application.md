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

    public \React\EventLoop\Timer\TimerInterface\LoopInterface $loop

The application loop



* Visibility: **public**


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

    void Gui\Application::__construct(array $defaultAttributes)

The constructor method



* Visibility: **public**


#### Arguments
* $defaultAttributes **array**



### getWindow

    \Gui\Components\Window Gui\Application::getWindow()

Returns the 1st Window of the Application



* Visibility: **public**




### ping

    float Gui\Application::ping()

Returns the communication time between php and lazarus



* Visibility: **public**




### addObject

    void Gui\Application::addObject(Object $object)

Put a object to the internal objects array



* Visibility: **public**


#### Arguments
* $object **Object** - &lt;p&gt;Component Object&lt;/p&gt;



### fire

    void Gui\Application::fire(string $eventName)

Fire an application event



* Visibility: **public**


#### Arguments
* $eventName **string** - &lt;p&gt;Event Name&lt;/p&gt;



### getNextObjectId

    integer Gui\Application::getNextObjectId()

Returns the next avaible object ID



* Visibility: **public**




### getObject

    Object Gui\Application::getObject(integer $id)

Get a object from the internal objects array



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;Object ID&lt;/p&gt;



### getVerboseLevel

    integer Gui\Application::getVerboseLevel()

Returns the verbose level



* Visibility: **public**




### on

    void Gui\Application::on(string $eventName, callable $eventHandler)

Returns the next avaible object ID



* Visibility: **public**


#### Arguments
* $eventName **string** - &lt;p&gt;the name of the event&lt;/p&gt;
* $eventHandler **callable** - &lt;p&gt;the callback&lt;/p&gt;



### run

    void Gui\Application::run()

Runs the application



* Visibility: **public**




### sendCommand

    void Gui\Application::sendCommand(string $method, array $params, callable $callback)

Send a command



* Visibility: **public**


#### Arguments
* $method **string** - &lt;p&gt;the method name&lt;/p&gt;
* $params **array** - &lt;p&gt;the method params&lt;/p&gt;
* $callback **callable** - &lt;p&gt;the callback&lt;/p&gt;



### sendEvent

    void Gui\Application::sendEvent(string $method, array $params)

Send an event



* Visibility: **public**


#### Arguments
* $method **string** - &lt;p&gt;the method name&lt;/p&gt;
* $params **array** - &lt;p&gt;the method params&lt;/p&gt;



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
* $method **string** - &lt;p&gt;the method name&lt;/p&gt;
* $params **array** - &lt;p&gt;the method params&lt;/p&gt;


