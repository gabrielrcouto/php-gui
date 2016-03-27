Gui\Ipc\Sender
===============

This is the Sender class

This class is used to send communication messages


* Class name: Sender
* Namespace: Gui\Ipc





Properties
----------


### $application

    public \Gui\Application $application

The application object



* Visibility: **public**


### $lastId

    public integer $lastId

The latest id available



* Visibility: **public**


### $receiver

    public \Gui\Ipc\Receiver $receiver

The receiver object



* Visibility: **public**


### $sendLaterMessagesBuffer

    protected string $sendLaterMessagesBuffer = ''

The buffer of messages to be sent



* Visibility: **protected**


Methods
-------


### __construct

    void Gui\Ipc\Sender::__construct(\Gui\Application $application, \Gui\Ipc\Receiver $receiver)

The constructor



* Visibility: **public**


#### Arguments
* $application **Gui\Application**
* $receiver **Gui\Ipc\Receiver**



### getLazarusJson

    String Gui\Ipc\Sender::getLazarusJson(\Gui\Ipc\MessageInterface $message)

Get a valid Lazarus RPC JSON String



* Visibility: **protected**


#### Arguments
* $message **Gui\Ipc\MessageInterface** - &lt;p&gt;Message to send&lt;/p&gt;



### out

    void Gui\Ipc\Sender::out(String $text)

Print debug information



* Visibility: **protected**


#### Arguments
* $text **String** - &lt;p&gt;Text to print&lt;/p&gt;



### processMessage

    void Gui\Ipc\Sender::processMessage(\Gui\Ipc\MessageInterface $message)

Process a message before sending - Useful to incrementing IDs



* Visibility: **protected**


#### Arguments
* $message **Gui\Ipc\MessageInterface** - &lt;p&gt;Message&lt;/p&gt;



### send

    void Gui\Ipc\Sender::send(\Gui\Ipc\MessageInterface $message)

Send a message



* Visibility: **public**


#### Arguments
* $message **Gui\Ipc\MessageInterface** - &lt;p&gt;Message to send&lt;/p&gt;



### tick

    void Gui\Ipc\Sender::tick()

Check and send queued messages



* Visibility: **public**




### waitReturn

    mixed Gui\Ipc\Sender::waitReturn(\Gui\Ipc\MessageInterface $message)

Send a message and wait for the return



* Visibility: **public**


#### Arguments
* $message **Gui\Ipc\MessageInterface**



### writeOnStream

    void Gui\Ipc\Sender::writeOnStream()

Write on stdin stream



* Visibility: **protected**



