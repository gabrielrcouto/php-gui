<?php
namespace Gui\Components;

/**
 * This is the Calendar Class
 *
 * It is a visual component for Calendar, a graphic allowing the user to
 * select a date which is returned as data to the calling routine.
 *
 * @author Everton da Rosa everton3x@gmail.com
 * @since 0.1
 * @todo Date format configuration.
 */
class Calendar extends VisualObject
{

    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TCalendar';

    /**
     * Sets the value of component.
     *
     * @param string $value the value
     *
     * @return self
     */
    public function setValue($value)
    {
        // See explanation of P.O.G in self::getValue()
        $datetime1 = date_create('1900-01-01');
        $datetime2 = date_create_from_format('d/m/Y', $value);
        $interval = date_diff($datetime1, $datetime2, true);
        $int = $interval->format('%a');

        $this->set('DateTime', $int + 2);

        return $this;
    }

    /**
     * Gets the value of component;
     *
     * In the Lazarus documentation for the TCalendar component there is a
     *  reference to the {@link http://lazarus-ccr.sourceforge.net/
     * docs/lcl/calendar/tcustomcalendar.date.html Date}
     * description property that should
     * return the string of the selected date. This works on Lazarus but
     * not on PHP-GUI. I do not know if this is a bug or something related
     *  to the stored false referenced in the documentation.
     *
     * An alternative way I found to implement the return of the selected
     *  date is to use the DateTime property return which is an integer
     * and add it (with tweaks) as of 01-01-1900 (I found this doing
     * some testing)
     *
     * @return string
     */
    public function getValue()
    {
        $date = date_create('1900-01-01');
        date_add($date, date_interval_create_from_date_string(($this->get('DateTime') - 2) . ' days'));
        return date_format($date, 'd/m/Y');
    }
}
