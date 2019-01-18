Gui\Components\InputFile
===============

This is the File Input Class

It is a visual component for select file input.


* Class name: InputFile
* Namespace: Gui\Components
* Parent class: Gui\Components\VisualObject



Constants
----------


### READ_ONLY

    const READ_ONLY = 'ofReadOnly'





### OVERWRITE_PROMPT

    const OVERWRITE_PROMPT = 'ofOverwritePrompt'





### HIDE_READ_ONLY

    const HIDE_READ_ONLY = 'ofHideReadOnly'





### NO_CHANGE_DIR

    const NO_CHANGE_DIR = 'ofNoChangeDir'





### SHOW_HELP

    const SHOW_HELP = 'ofShowHelp'





### NO_VALIDATE

    const NO_VALIDATE = 'ofNoValidate'





### ALLOW_MULTI_SELECT

    const ALLOW_MULTI_SELECT = 'ofAllowMultiSelect'





### EXTENSION_DIFFERENT

    const EXTENSION_DIFFERENT = 'ofExtensionDifferent'





### PATH_MUST_EXIST

    const PATH_MUST_EXIST = 'ofPathMustExist'





### FILE_MUST_EXIST

    const FILE_MUST_EXIST = 'ofFileMustExist'





### CREATE_PROMPT

    const CREATE_PROMPT = 'ofCreatePrompt'





### SHARE_AWARE

    const SHARE_AWARE = 'ofShareAware'





### NO_READ_ONLY_RETURN

    const NO_READ_ONLY_RETURN = 'ofNoReadOnlyReturn'





### NO_TEST_FILE_CREATE

    const NO_TEST_FILE_CREATE = 'ofNoTestFileCreate'





### NO_NETWORK_BUTTON

    const NO_NETWORK_BUTTON = 'ofNoNetworkButton'





### NO_LONG_NAMES

    const NO_LONG_NAMES = 'ofNoLongNames'





### OLD_STYLE_DIALOG

    const OLD_STYLE_DIALOG = 'ofOldStyleDialog'





### NO_DEREFERENCE_LINKS

    const NO_DEREFERENCE_LINKS = 'ofNoDereferenceLinks'





### ENABLE_INCLUDE_NOTIFY

    const ENABLE_INCLUDE_NOTIFY = 'ofEnableIncludeNotify'





### ENABLE_SIZING

    const ENABLE_SIZING = 'ofEnableSizing'





### DONT_ADD_TO_RECENT

    const DONT_ADD_TO_RECENT = 'ofDontAddToRecent'





### FORCE_SHOW_HIDDEN

    const FORCE_SHOW_HIDDEN = 'ofForceShowHidden'





### VIEW_DETAIL

    const VIEW_DETAIL = 'ofViewDetail'





### AUTO_PREVIEW

    const AUTO_PREVIEW = 'ofAutoPreview'





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


### getValue

    array Gui\Components\InputFile::getValue()

Gets the files selected.



* Visibility: **public**




### setTitle

    \Gui\Components\InputFile Gui\Components\InputFile::setTitle(string $title)

Sets the title that appears on the select dialog.



* Visibility: **public**


#### Arguments
* $title **string**



### getTitle

    string Gui\Components\InputFile::getTitle()

Gets the title that appears on the select dialog.



* Visibility: **public**




### setDialogOptions

    \Gui\Components\InputFile Gui\Components\InputFile::setDialogOptions(string $options)

Sets teh dialog options.



* Visibility: **public**


#### Arguments
* $options **string**



### getDialogOptions

    array Gui\Components\InputFile::getDialogOptions()

Gets the dialog options.



* Visibility: **public**




### setBaseDir

    \Gui\Components\InputFile Gui\Components\InputFile::setBaseDir(string $path)

Sets the  initial directory for searching.



* Visibility: **public**


#### Arguments
* $path **string**



### getBaseDir

    string Gui\Components\InputFile::getBaseDir()

Gets the  base directory for searching.



* Visibility: **public**




### setExtensionFilter

    \Gui\Components\InputFile Gui\Components\InputFile::setExtensionFilter(array $extensions)

Sets filter for dialog extensions.



* Visibility: **public**


#### Arguments
* $extensions **array** - &lt;p&gt;the extension list where key is extension (xml, json, ...)
and value is extension description.&lt;/p&gt;



### getExtensionFilter

    array Gui\Components\InputFile::getExtensionFilter()

Gets filter for dialog extensions.



* Visibility: **public**




### setHideDirectory

    \Gui\Components\InputFile Gui\Components\InputFile::setHideDirectory(boolean $hide)

Sets to hide directory name from edit.



* Visibility: **public**


#### Arguments
* $hide **boolean**



### isHidedirectory

    boolean Gui\Components\InputFile::isHidedirectory()

Gets if directories are omitted from edit.



* Visibility: **public**




### setAcceptInput

    \Gui\Components\InputFile Gui\Components\InputFile::setAcceptInput(string $bool)

Sets if direct data input to the Edit Box is permitted.



* Visibility: **public**


#### Arguments
* $bool **string**



### getAcceptInput

    string Gui\Components\InputFile::getAcceptInput()

Gets if direct data input to the Edit Box is permitted.



* Visibility: **public**




### setButtonOnlyWhenFocused

    \Gui\Components\InputFile Gui\Components\InputFile::setButtonOnlyWhenFocused(boolean $option)

Sets if the button only appears when the control receives focus.



* Visibility: **public**


#### Arguments
* $option **boolean**



### isButtonOnlyWhenFocused

    boolean Gui\Components\InputFile::isButtonOnlyWhenFocused()

Gets if the button only appears when the control receives focus.



* Visibility: **public**




### setAutoSelect

    \Gui\Components\InputFile Gui\Components\InputFile::setAutoSelect(boolean $option)

Sets if True, the edit control will select all its text when it receives focus or when the Enter key is pressed.



* Visibility: **public**


#### Arguments
* $option **boolean**



### isAutoSelect

    boolean Gui\Components\InputFile::isAutoSelect()

Gets if True, the edit control will select all its text when it receives focus or when the Enter key is pressed.



* Visibility: **public**




### countFiles

    integer Gui\Components\InputFile::countFiles()

Get number of files selected.



* Visibility: **public**




### parseOptionString

    array Gui\Components\InputFile::parseOptionString(string $options)

Parse an option string received from Lazarus.



* Visibility: **private**


#### Arguments
* $options **string**



### getOptionString

    string Gui\Components\InputFile::getOptionString(array $options)

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


