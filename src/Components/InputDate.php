<?php
namespace Gui\Components;

/**
 * This is the InputDate Class
 *
 * It is a visual component for InputDate, an EditBox to hold a date,
 * with an attached SpeedButton that will summon a date selection (calendar) dialog.
 *
 * @author Everton da Rosa everton3x@gmail.com
 * @since 0.1
 */
class InputDate extends VisualObject
{
    use OptionAware;

    /**
     * dsShowHeadings
     */
    const SHOW_HEADINGS = 'dsShowHeadings';

    /**
     * dsShowDayNames
     */
    const SHOW_DAY_NAMES = 'dsShowDayNames';

    /**
     * dsNoMonthChange
     */
    const NO_MONTH_CHANGE = 'dsNoMonthChange';

    /**
     * dsShowWeekNumbers
     */
    const SHOW_WEEK_NUMBERS = 'dsShowWeekNumbers';

    /**
     * dsStartMonday
     */
    const START_MONDAY = 'dsStartMonday';

    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TDateEdit';

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

    /**
     * Gets the dialog options.
     *
     * @return array the options dialog
     */
    public function getDialogOptions()
    {
        $options = $this->get('CalendarDisplaySettings');

        return $this->parseOptionString($options);
    }

    /**
     * Sets teh dialog options.
     *
     * @param string $options the options.
     * @return self
     */
    public function setDialogOptions(...$options)
    {
        $str_options = $this->getOptionString($options);
        $this->set('CalendarDisplaySettings', $str_options);

        return $this;
    }
}
