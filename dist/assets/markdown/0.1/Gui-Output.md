Gui\Output
===============

This is the Output Class

This class is used to send the output easier


* Class name: Output
* Namespace: Gui





Properties
----------


### $out

    protected resource $out = STDOUT

The resource for out



* Visibility: **protected**
* This property is **static**.


### $err

    protected resource $err = STDERR

The resource for err



* Visibility: **protected**
* This property is **static**.


### $colors

    private array $colors = array('black' => 30, 'red' => 31, 'green' => 32, 'yellow' => 33, 'blue' => 34, 'magenta' => 35, 'cyan' => 36, 'white' => 37)





* Visibility: **private**
* This property is **static**.


Methods
-------


### out

    void Gui\Output::out(string $string, string $color)

This method is used to send some text to STDOUT, maybe with some color



* Visibility: **public**
* This method is **static**.


#### Arguments
* $string **string** - &lt;p&gt;the text to be sent to STDOUT&lt;/p&gt;
* $color **string** - &lt;p&gt;the color to colorize your text&lt;/p&gt;



### err

    void Gui\Output::err(string $string)

This method is used to send some text to STDERR



* Visibility: **public**
* This method is **static**.


#### Arguments
* $string **string** - &lt;p&gt;the text to be sent to STDERR&lt;/p&gt;



### colorize

    string Gui\Output::colorize(string $string, string $color)

This method is used to colorize some text



* Visibility: **private**
* This method is **static**.


#### Arguments
* $string **string** - &lt;p&gt;the text to be colorized&lt;/p&gt;
* $color **string** - &lt;p&gt;the color to colorize your&lt;/p&gt;


