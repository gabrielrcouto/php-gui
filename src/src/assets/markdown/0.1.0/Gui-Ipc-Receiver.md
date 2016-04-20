Gui\Ipc\Receiver
===============

This is the Receiver class

This class is used to receive communication messages


* Class name: Receiver
* Namespace: Gui\Ipc





Properties
----------


### $application

    public \Gui\Application $application

The application object



* Visibility: **public**


### $buffer

    protected string $buffer = ''

The buffer of received messages



* Visibility: **protected**


### $messageCallbacks

    public array $messageCallbacks = array()

Array of callbacks



* Visibility: **public**


### $isWaitingMessage

    protected boolean $isWaitingMessage = false

Defines if is waiting message



* Visibility: **protected**


### $parseMessagesBuffer

    protected array $parseMessagesBuffer = array()

Array of messages in buffer



* Visibility: **protected**


### $waitingMessageId

    protected integer $waitingMessageId

The id of the waitingMessage



* Visibility: **protected**


### $waitingMessageResult

    protected mixed $waitingMessageResult

The return of the waitingMessage



* Visibility: **protected**


Methods
-------


### __construct

    void Gui\Ipc\Receiver::__construct(\Gui\Application $application)

The constructor



* Visibility: **public**


#### Arguments
* $application **Gui\Application**



### addMessageCallback

    void Gui\Ipc\Receiver::addMessageCallback(integer $id, callable $callback)

When the result of a message arrives, we call a callback



* Visibility: **public**


#### Arguments
* $id **integer**
* $callback **callable**



### callObjectEventListener

    void Gui\Ipc\Receiver::callObjectEventListener(integer $id, string $eventName)

Fire a event on a object



* Visibility: **public**


#### Arguments
* $id **integer**
* $eventName **string**



### callMessageCallback

    void Gui\Ipc\Receiver::callMessageCallback(integer $id, string|Array|Object|integer $result)

Result received, time to call the message callback



* Visibility: **public**


#### Arguments
* $id **integer**
* $result **string|Array|Object|integer**



### jsonDecode

    \Gui\Ipc\MessageInterface|void Gui\Ipc\Receiver::jsonDecode(string $json)

Decode a received message



* Visibility: **protected**


#### Arguments
* $json **string**



### onData

    void Gui\Ipc\Receiver::onData(string $data)

Process Stdout handler



* Visibility: **public**


#### Arguments
* $data **string**



### parseDebug

    void Gui\Ipc\Receiver::parseDebug($message)

Parse a debug message



* Visibility: **protected**


#### Arguments
* $message **mixed**



### parseNormal

    void Gui\Ipc\Receiver::parseNormal($message)

Parse a normal message, can be a command, command result or an event



* Visibility: **protected**


#### Arguments
* $message **mixed**



### prepareOutput

    String Gui\Ipc\Receiver::prepareOutput(string $string)

Construct the output string



* Visibility: **protected**


#### Arguments
* $string **string**



### tick

    void Gui\Ipc\Receiver::tick()

Read the stdout pipe from Lazarus process. This function uses
stream_select to be non blocking



* Visibility: **public**




### waitMessage

    mixed Gui\Ipc\Receiver::waitMessage(\React\Stream\Stream $stdout, \Gui\Ipc\MessageInterface $message)

Wait a message result



* Visibility: **public**


#### Arguments
* $stdout **React\Stream\Stream**
* $message **Gui\Ipc\MessageInterface**


