Gui\Components\InputDate
===============

This is the InputDate Class

It is a visual component for InputDate, an EditBox to hold a date,
with an attached SpeedButton that will summon a date selection (calendar) dialog.


* Class name: InputDate
* Namespace: Gui\Components
* Parent class: Gui\Components\VisualObject



Constants
----------


### SHOW_HEADINGS

    const SHOW_HEADINGS = 'dsShowHeadings'





### SHOW_DAY_NAMES

    const SHOW_DAY_NAMES = 'dsShowDayNames'





### NO_MONTH_CHANGE

    const NO_MONTH_CHANGE = 'dsNoMonthChange'





### SHOW_WEEK_NUMBERS

    const SHOW_WEEK_NUMBERS = 'dsShowWeekNumbers'





### START_MONDAY

    const START_MONDAY = 'dsStartMonday'





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


### setButtonOnlyWhenFocused

    \Gui\Components\InputDate Gui\Components\InputDate::setButtonOnlyWhenFocused(boolean $option)

Sets if the button only appears when the control receives focus.



* Visibility: **public**


#### Arguments
* $option **boolean**



### isButtonOnlyWhenFocused

    boolean Gui\Components\InputDate::isButtonOnlyWhenFocused()

Gets if the button only appears when the control receives focus.



* Visibility: **public**




### setAcceptInput

    \Gui\Components\InputDate Gui\Components\InputDate::setAcceptInput(string $bool)

Sets if direct data input to the Edit Box is permitted.



* Visibility: **public**


#### Arguments
* $bool **string**



### getAcceptInput

    string Gui\Components\InputDate::getAcceptInput()

Gets if direct data input to the Edit Box is permitted.



* Visibility: **public**




### setValue

    \Gui\Components\InputDate Gui\Components\InputDate::setValue(string $value)

Sets the value of component.



* Visibility: **public**


#### Arguments
* $value **string**



### getValue

    string Gui\Components\InputDate::getValue()

Gets the value of component;



* Visibility: **public**




### getDialogOptions

    array Gui\Components\InputDate::getDialogOptions()

Gets the dialog options.



* Visibility: **public**




### setDialogOptions

    \Gui\Components\InputDate Gui\Components\InputDate::setDialogOptions(string $options)

Sets teh dialog options.



* Visibility: **public**


#### Arguments
* $options **string**



### parseOptionString

    array Gui\Components\InputDate::parseOptionString(string $options)

Parse an option string received from Lazarus.



* Visibility: **private**


#### Arguments
* $options **string**



### getOptionString

    string Gui\Components\InputDate::getOptionString(array $options)

Returns a string with the representation [option1, option2, .

..] to be configured by Lazarus.

* Visibility: **private**


#### Arguments
* $options **array**



### getAutoSize

    Boolean Gui\Components\VisualObjectInterface::getAutoSize()

Get the auto size



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface




### setAutoSize

    \Gui\Components\VisualObjectInterface Gui\Components\VisualObjectInterface::setAutoSize(Boolean $autoSize)

Set the auto size



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface


#### Arguments
* $autoSize **Boolean**



### getBackgroundColor

    String Gui\Components\VisualObjectInterface::getBackgroundColor()

Get the background color



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface




### setBackgroundColor

    \Gui\Components\VisualObjectInterface Gui\Components\VisualObjectInterface::setBackgroundColor(string $color)

Set the background Color



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface


#### Arguments
* $color **string**



### getBottom

    integer Gui\Components\VisualObjectInterface::getBottom()

Gets the value of bottom in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface




### setBottom

    \Gui\Components\VisualObjectInterface Gui\Components\VisualObjectInterface::setBottom(integer $bottom)

Sets the value of bottom in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface


#### Arguments
* $bottom **integer**



### getHeight

    integer Gui\Components\VisualObjectInterface::getHeight()

Gets the value of height in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface




### setHeight

    \Gui\Components\VisualObjectInterface Gui\Components\VisualObjectInterface::setHeight(integer $height)

Sets the value of height in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface


#### Arguments
* $height **integer**



### getLeft

    integer Gui\Components\VisualObjectInterface::getLeft()

Gets the value of left in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface




### setLeft

    \Gui\Components\VisualObjectInterface Gui\Components\VisualObjectInterface::setLeft(integer $left)

Sets the value of left in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface


#### Arguments
* $left **integer**



### getRight

    integer Gui\Components\VisualObjectInterface::getRight()

Gets the value of right in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface




### setRight

    \Gui\Components\VisualObjectInterface Gui\Components\VisualObjectInterface::setRight(integer $right)

Sets the value of right in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface


#### Arguments
* $right **integer**



### getTop

    integer Gui\Components\VisualObjectInterface::getTop()

Gets the value of top in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface




### setTop

    \Gui\Components\VisualObjectInterface Gui\Components\VisualObjectInterface::setTop(integer $top)

Sets the value of top in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface


#### Arguments
* $top **integer**



### getWidth

    integer Gui\Components\VisualObjectInterface::getWidth()

Gets the value of width in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface




### setWidth

    \Gui\Components\VisualObjectInterface Gui\Components\VisualObjectInterface::setWidth(integer $width)

Sets the value of width in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface


#### Arguments
* $width **integer**



### getVisible

    boolean Gui\Components\VisualObjectInterface::getVisible()

Gets the value of visible in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface




### setVisible

    \Gui\Components\VisualObjectInterface Gui\Components\VisualObjectInterface::setVisible(boolean $visible)

Sets the value of visible in pixel.



* Visibility: **public**
* This method is defined by Gui\Components\VisualObjectInterface


#### Arguments
* $visible **boolean**



### __construct

    void Gui\Components\AbstractObject::__construct(array $defaultAttributes, \Gui\Components\ContainerObjectInterface $parent, \Gui\Application $application)

The constructor



* Visibility: **public**
* This method is defined by Gui\Components\AbstractObject


#### Arguments
* $defaultAttributes **array**
* $parent **Gui\Components\ContainerObjectInterface**
* $application **Gui\Application**



### __call

    self|mixed Gui\Components\AbstractObject::__call(string $method, array $params)

The special method used to do the getters/setters for special properties



* Visibility: **public**
* This method is defined by Gui\Components\AbstractObject


#### Arguments
* $method **string**
* $params **array**



### call

    void Gui\Components\AbstractObject::call(string $method, array $params, boolean $isCommand)

This method is used to send an object command/envent to lazarus



* Visibility: **protected**
* This method is defined by Gui\Components\AbstractObject


#### Arguments
* $method **string**
* $params **array**
* $isCommand **boolean**



### set

    void Gui\Components\AbstractObject::set(string $name, mixed $value)

this method is used to send the IPC message when a property is set



* Visibility: **protected**
* This method is defined by Gui\Components\AbstractObject


#### Arguments
* $name **string**
* $value **mixed**



### get

    mixed Gui\Components\AbstractObject::get(string $name)

This magic method is used to send the IPC message when a property is get



* Visibility: **protected**
* This method is defined by Gui\Components\AbstractObject


#### Arguments
* $name **string**



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


