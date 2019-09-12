<?php
namespace Gui\Components;

use Gui\Application;

/**
 * Visual component for spin edit.
 *
 * @author WinterSilence
 * @since 0.2
 */
class InputSpin extends VisualObject
{
    use InputEvents;
    
    /**
     * {@inheritdoc}
     */
    protected $lazarusClass = 'TSpinEdit';

    /**
     * {@inheritdoc}
     */
    public function __construct(
        array $defaultAttributes = [],
        ContainerObjectInterface $parent = null,
        Application $application = null
    )
    {
        if ($defaultAttributes) {
            $defaultAttributes = array_combine(
                array_map('ucfirst', array_keys($defaultAttributes)),
                array_values($defaultAttributes)
            );
        }
        $defaultAttributes += $this->getDefaultAttributes();
        
        parent::__construct($defaultAttributes, $parent, $application);
    }
    
    /**
     * Returns default attribute values.
     * 
     * @return array
     */
    public function getDefaultAttributes()
    {
        return [
            'Value'     => 0,
            'MinValue'  => 0,
            'MaxValue'  => 100,
            'Increment' => 1,
        ];
    }
    
    /**
     * Gets component value.
     * 
     * @return int
     */
    public function getValue()
    {
        return $this->get('Value');
    }
    
    /**
     * Sets component value.
     *
     * @param int $value
     * @return self
     */
    public function setValue($value)
    {
        $this->set('Value', (int) $value);
        return $this;
    }
    
    /**
     * Gets the maximal value allowed for the component.
     *
     * @return int
     */
    public function getMaxValue()
    {
        return $this->get('MaxValue');
    }
    
    /**
     * Sets the maximal value allowed for the component.
     *
     * @param int $value
     * @return self
     */
    public function setMaxValue($value)
    {
        $this->set('MaxValue', (int) $value);
        return $this;
    }
    
    /**
     * Gets the minimal value allowed for the component.
     *
     * @return int
     */
    public function getMinValue()
    {
        return $this->get('MinValue');
    }
    
    /**
     * Sets the minimal value allowed for the component.
     *
     * @param int $value
     * @return self
     */
    public function setMinValue($value)
    {
        $this->set('MinValue', (int) $value);
        return $this;
    }
    
    /**
     * Gets value's increment for the component. 
     * 
     * @return int
     */
    public function getIncrement()
    {
        return $this->get('Increment');
    }
    
    /**
     * The value by which the value of the control should be increased/decresed when 
     * the user clicks one of the arrows or one of the keyboard up/down arrows.
     *
     * @param int $value
     * @return self
     */
    public function setIncrement($value)
    {
        $this->set('Increment', max(1, (int) $value));
        return $this;
    }
}
