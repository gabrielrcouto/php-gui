<?php

namespace Gui\Components;

/**
 * Button
 *
 * @property String $value Button caption
 */
class Button extends Object
{
    public $lazarusClass = 'TButton';
    protected $propertiesNameTransform = [
        'value' => 'caption'
    ];
    protected $value;
}