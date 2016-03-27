Gui\Components\Select
===============

This is the Select Class

It is a visual component for select


* Class name: Select
* Namespace: Gui\Components
* Parent class: Gui\Components\Object





Properties
----------


### $lazarusClass

    protected string $lazarusClass = 'TObject'

The lazarus class as string



* Visibility: **protected**


### $lazarusObjectId

    protected integer $lazarusObjectId

The communication object id



* Visibility: **protected**


### $application

    protected \Gui\Application $application

The application object



* Visibility: **protected**


### $eventHandlers

    protected array $eventHandlers = array()

The array of callbacks



* Visibility: **protected**


### $runTimeProperties

    protected array $runTimeProperties = array()

The array of special properties



* Visibility: **protected**


Methods
-------


### setItems

    \Gui\Components\Select Gui\Components\Select::setItems(array $items)

Sets the items



* Visibility: **public**


#### Arguments
* $items **array**



### getChecked

    integer Gui\Components\Select::getChecked()

Gets the checked item id



* Visibility: **public**




### setReadOnly

    \Gui\Components\Select Gui\Components\Select::setReadOnly($val)

Set if is read only



* Visibility: **public**


#### Arguments
* $val **mixed**



### __construct

    void Gui\Components\Object::__construct(array $defaultAttributes, Object $parent, \Gui\Application $application)

The constructor



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $defaultAttributes **array**
* $parent **Object**
* $application **Gui\Application**



### __call

    self|mixed Gui\Components\Object::__call(string $method, array $params)

The special method used to do the getters/setters for special properties



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $method **string**
* $params **array**



### call

    void Gui\Components\Object::call(string $method, array $params, boolean $isCommand)

This method is used to send an object command/envent to lazarus



* Visibility: **protected**
* This method is defined by Gui\Components\Object


#### Arguments
* $method **string**
* $params **array**
* $isCommand **boolean**



### set

    void Gui\Components\Object::set(string $name, mixed $value)

this method is used to send the IPC message when a property is set



* Visibility: **protected**
* This method is defined by Gui\Components\Object


#### Arguments
* $name **string** - &lt;p&gt;Property name&lt;/p&gt;
* $value **mixed** - &lt;p&gt;Property value&lt;/p&gt;



### get

    mixed Gui\Components\Object::get(string $name)

This magic method is used to send the IPC message when a property is get



* Visibility: **protected**
* This method is defined by Gui\Components\Object


#### Arguments
* $name **string** - &lt;p&gt;Property name&lt;/p&gt;



### fire

    void Gui\Components\Object::fire(string $eventName)

Fire an object event



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $eventName **string** - &lt;p&gt;Event Name&lt;/p&gt;



### on

    void Gui\Components\Object::on(string $eventName, callable $eventHandler)

Add a listener to an event



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $eventName **string** - &lt;p&gt;Event Name&lt;/p&gt;
* $eventHandler **callable** - &lt;p&gt;Event Handler Function&lt;/p&gt;



### getAutoSize

    Boolean Gui\Components\Object::getAutoSize()

Get the auto size



* Visibility: **public**
* This method is defined by Gui\Components\Object




### setAutoSize

    \Gui\Components\Object Gui\Components\Object::setAutoSize(Boolean $autoSize)

Set the auto size



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $autoSize **Boolean** - &lt;p&gt;True = Enabled&lt;/p&gt;



### getBackgroundColor

    String Gui\Components\Object::getBackgroundColor()

Get the background color



* Visibility: **public**
* This method is defined by Gui\Components\Object




### setBackgroundColor

    \Gui\Components\Object Gui\Components\Object::setBackgroundColor(string $color)

Set the background Color



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $color **string** - &lt;p&gt;Color &#039;#123456&#039;&lt;/p&gt;



### getBottom

    integer Gui\Components\Object::getBottom()

Gets the value of bottom in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object




### setBottom

    \Gui\Components\Object Gui\Components\Object::setBottom(integer $bottom)

Sets the value of bottom in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $bottom **integer** - &lt;p&gt;the bottom&lt;/p&gt;



### getHeight

    integer Gui\Components\Object::getHeight()

Gets the value of height in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object




### setHeight

    \Gui\Components\Object Gui\Components\Object::setHeight(integer $height)

Sets the value of height in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $height **integer** - &lt;p&gt;the height&lt;/p&gt;



### getLazarusObjectId

    mixed Gui\Components\Object::getLazarusObjectId()

Gets the value of lazarusObjectId.



* Visibility: **public**
* This method is defined by Gui\Components\Object




### getLazarusClass

    mixed Gui\Components\Object::getLazarusClass()

Gets the value of lazarusClass.



* Visibility: **public**
* This method is defined by Gui\Components\Object




### getLeft

    integer Gui\Components\Object::getLeft()

Gets the value of left in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object




### setLeft

    \Gui\Components\Object Gui\Components\Object::setLeft(integer $left)

Sets the value of left in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $left **integer** - &lt;p&gt;the left&lt;/p&gt;



### getRight

    integer Gui\Components\Object::getRight()

Gets the value of right in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object




### setRight

    \Gui\Components\Object Gui\Components\Object::setRight(integer $right)

Sets the value of right in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $right **integer** - &lt;p&gt;the right&lt;/p&gt;



### getTop

    integer Gui\Components\Object::getTop()

Gets the value of top in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object




### setTop

    \Gui\Components\Object Gui\Components\Object::setTop(integer $top)

Sets the value of top in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $top **integer** - &lt;p&gt;the top&lt;/p&gt;



### getWidth

    integer Gui\Components\Object::getWidth()

Gets the value of width in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object




### setWidth

    \Gui\Components\Object Gui\Components\Object::setWidth(integer $width)

Sets the value of width in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $width **integer** - &lt;p&gt;the width&lt;/p&gt;



### getVisible

    boolean Gui\Components\Object::getVisible()

Gets the value of visible in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object




### setVisible

    \Gui\Components\Object Gui\Components\Object::setVisible(boolean $visible)

Sets the value of visible in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\Object


#### Arguments
* $visible **boolean** - &lt;p&gt;the visible&lt;/p&gt;


