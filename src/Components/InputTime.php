<?php
namespace Gui\Components;

/**
 * This is the InputTime Class
 *
 * It is a visual component for InputTime, an EditBox to hold a time,
 * with an attached SpeedButton that will summon a time selection dialog.
 *
 * @author Everton da Rosa everton3x@gmail.com
 * @since 0.1
 */
class InputTime extends VisualObject
{

    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TTimeEdit';

    /**
     * Sets if the button only appears when the control receives focus.
     *
     * @param bool $option True to activate option. False is default.
     * @return self
     */
    public function setButtonOnlyWhenFocused($option)
    {
        $this->set('ButtonOnlyWhenFocused', $option);

        return $this;
    }

    /**
     * Gets if the button only appears when the control receives focus.
     *
     * @return bool
     */
    public function isButtonOnlyWhenFocused()
    {
        return (bool) $this->get('ButtonOnlyWhenFocused');
    }

    /**
     * Sets if direct data input to the Edit Box is permitted.
     *
     * @param string $bool  if True, direct data input to the Edit Box is permitted. Default is TRUE.
     *
     * @return self
     */
    public function setAcceptInput($bool)
    {
        $this->set('DirectInput', $bool);

        return $this;
    }

    /**
     * Gets if direct data input to the Edit Box is permitted.
     *
     *
     * @return string
     */
    public function getAcceptInput()
    {
        return $this->get('DirectInput');
    }

    /**
     * Sets the value of component.
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
     * Gets the value of component;
     *
     * @return string
     */
    public function getValue()
    {
        return $this->get('Text');
    }
}
