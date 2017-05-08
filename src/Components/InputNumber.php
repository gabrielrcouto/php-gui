<?php
namespace Gui\Components;

use Gui\Exception\ComponentException;

/**
 * This is the InputNumber Class
 *
 * It is a visual component for input numbers -- integer and float
 *
 * @author Everton da Rosa everton3x@gmail.com
 * @since 0.1
 */
class InputNumber extends VisualObject
{

    /**
     * The lazarus class string to integer number control.
     *
     * @var string $lazIntClass
     */
    protected $lazIntClass = 'TSpinEdit';

    /**
     * The lazarus class string to float number control.
     *
     * @var string $lazIntClass
     */
    protected $lazFloatClass = 'TFloatSpinEdit';

    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = '';

    /**
     * The class constructor.
     *
     * @param bool $isFloat If TRUE, define controlto manage float number. FALSE (default), to integer numbers.
     * @param array $defaultAttributes
     * @param \Gui\Components\ContainerObjectInterface $parent
     * @param type $application
     */
    public function __construct(
        $isFloat = false,
        array $defaultAttributes = array(),
        ContainerObjectInterface $parent = null,
        $application = null
    ) {
        if ($isFloat) {
            $this->lazarusClass = $this->lazFloatClass;
        } else {
            $this->lazarusClass = $this->lazIntClass;
        }

        parent::__construct($defaultAttributes, $parent, $application);
    }

    /**
     * Sets the value by which the value of the control should be
     * increased/decresed when the user clicks one of the arrows or one of the keyboard up/down arrows.
     *
     * @param int|float $value
     * @return $this
     */
    public function setIncrement($value)
    {
        $this->set('Increment', $value);

        return $this;
    }

    /**
     * Gets the value by which the value of the control should be
     * increased/decresed when the user clicks one of the arrows or one of the keyboard up/down arrows.
     *
     * @return int|float
     */
    public function getIncrement($value)
    {
        return $this->get('Increment');
    }

    /**
     * Sets de max value.
     *
     * @param int|float $max
     * @return $this
     */
    public function setMax($max)
    {
        $this->set('MaxValue', $max);
        return $this;
    }

    /**
     * Gets the max value.
     *
     * @return int|float
     */
    public function getMax()
    {
        return $this->get('MaxValue');
    }

    /**
     * Sets de min value.
     *
     * @param int|float $min
     * @return $this
     */
    public function setMin($min)
    {
        $this->set('MinValue', $min);
        return $this;
    }

    /**
     * Gets the min value.
     *
     * @return int|float
     */
    public function getMin()
    {
        return $this->get('MinValue');
    }

    /**
     * Sets the value of value.
     *
     * @param int|float $value the value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->set('Value', $value);

        return $this;
    }

    /**
     * Gets the value of value;
     *
     * @return int|float
     */
    public function getValue()
    {
        return $this->get('Value');
    }

    /**
     * Sets decimals for control.
     *
     * @param int $decimal
     * @return $this
     * @throws ComponentException
     */
    public function setDecimals($decimal)
    {
        if ($this->lazarusClass === $this->lazFloatClass) {
            $this->set('DecimalPlaces', $decimal);
            return $this;
        } else {
            throw new ComponentException('Invalid call to InputNumber::setDecimal() at not type TFloatSpinEdit type');
        }
    }

    /**
     * Gest de decimal.
     *
     * @return int
     */
    public function getDecimals()
    {
        if ($this->lazarusClass === $this->lazFloatClass) {
            return $this->get('DecimalPlaces');
        } else {
            throw new ComponentException('Invalid call to InputNumber::getDecimal() at not type TFloatSpinEdit type');
        }
    }
}
