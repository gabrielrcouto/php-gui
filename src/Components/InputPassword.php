<?php
namespace Gui\Components;

/**
 * This is the InputPassword Class
 *
 * It is a visual component for InputPassword, a box with characters masked out to avoid unauthorised reading
 *
 *
 *
 * @author Everton da Rosa everton3x.at.gmail.com
 * @since 0.1
 */
class InputPassword extends VisualObject
{

    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TEdit';

    /**
     * The class constructor.
     *
     * @param array $defaultAttributes
     * @param \Gui\Components\ContainerObjectInterface $parent
     * @param type $application
     */
    public function __construct(
        array $defaultAttributes = array(),
        ContainerObjectInterface $parent = null,
        $application = null
    ) {
        parent::__construct($defaultAttributes, $parent, $application);

        // Required to configure the component as a password field.
        $this->setEchoMode();
    }

    /**
     * Sets the value of value.
     *
     * @param string $value the value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->set('Text', $value);

        return $this;
    }

    /**
     * Gets the value of value;
     *
     * @return string
     */
    public function getValue()
    {
        return $this->get('Text');
    }

    /**
     * Enables transforming a TEdit into password field.
     *
     * @return self
     */
    private function setEchoMode()
    {
        $this->set('EchoMode', 'emPassword');

        return $this;
    }
}
