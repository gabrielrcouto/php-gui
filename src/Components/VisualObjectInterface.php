<?php

namespace Gui\Components;

/**
 * It is a visual component interface
 *
 * @author Rodrigo Azevedo @rodrigowbazeved
 * @since 0.1
 */
interface VisualObjectInterface
{
    /**
     * Get the auto size
     *
     * @return Boolean
     */
    public function getAutoSize();

    /**
     * Set the auto size
     *
     * @param Boolean $autoSize True = Enabled
     *
     * @return self
     */
    public function setAutoSize($autoSize);

    /**
     * Get the background color
     *
     * @return String
     */
    public function getBackgroundColor();

    /**
     * Set the background Color
     *
     * @param string $color Color '#123456'
     *
     * @return self
     */
    public function setBackgroundColor($color);

    /**
     * Gets the value of bottom in pixel.
     *
     * @return int
     */
    public function getBottom();

    /**
     * Sets the value of bottom in pixel.
     *
     * @param int $bottom the bottom
     *
     * @return self
     */
    public function setBottom($bottom);

    /**
     * Gets the value of height in pixel.
     *
     * @return int
     */
    public function getHeight();

    /**
     * Sets the value of height in pixel.
     *
     * @param int $height the height
     *
     * @return self
     */
    public function setHeight($height);

    /**
     * Gets the value of left in pixel.
     *
     * @return int
     */
    public function getLeft();

    /**
     * Sets the value of left in pixel.
     *
     * @param int $left the left
     *
     * @return self
     */
    public function setLeft($left);

    /**
     * Gets the value of right in pixel.
     *
     * @return int
     */
    public function getRight();

    /**
     * Sets the value of right in pixel.
     *
     * @param int $right the right
     *
     * @return self
     */
    public function setRight($right);

    /**
     * Gets the value of top in pixel.
     *
     * @return int
     */
    public function getTop();

    /**
     * Sets the value of top in pixel.
     *
     * @param int $top the top
     *
     * @return self
     */
    public function setTop($top);

    /**
     * Gets the value of width in pixel.
     *
     * @return int
     */
    public function getWidth();

    /**
     * Sets the value of width in pixel.
     *
     * @param int $width the width
     *
     * @return self
     */
    public function setWidth($width);

    /**
     * Gets the value of visible in pixel.
     *
     * @return boolean
     */
    public function getVisible();

    /**
     * Sets the value of visible in pixel.
     *
     * @param boolean $visible the visible
     *
     * @return self
     */
    public function setVisible($visible);
}
