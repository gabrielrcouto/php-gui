<?php

namespace Gui\Components;

use Gui\Color;

/**
 * It is a visual component
 *
 * @author Rodrigo Azevedo @rodrigowbazeved
 * @since 0.1
 */
abstract class VisualObject extends AbstractObject implements VisualObjectInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAutoSize()
    {
        return $this->get('autosize');
    }

    /**
     * {@inheritdoc}
     */
    public function setAutoSize($autoSize)
    {
        $this->set('autosize', $autoSize);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackgroundColor()
    {
        return $this->get('color');
    }

    /**
     * {@inheritdoc}
     */
    public function setBackgroundColor($color)
    {
        $this->set('color', Color::toLazarus($color));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBottom()
    {
        return $this->get('bottom');
    }

    /**
     * {@inheritdoc}
     */
    public function setBottom($bottom)
    {
        $this->set('bottom', $bottom);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight()
    {
        return $this->get('height');
    }

    /**
     * {@inheritdoc}
     */
    public function setHeight($height)
    {
        $this->set('height', $height);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLeft()
    {
        return $this->get('left');
    }

    /**
     * {@inheritdoc}
     */
    public function setLeft($left)
    {
        $this->set('left', $left);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRight()
    {
        return $this->get('right');
    }

    /**
     * {@inheritdoc}
     */
    public function setRight($right)
    {
        $this->set('right', $right);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTop()
    {
        return $this->get('top');
    }

    /**
     * {@inheritdoc}
     */
    public function setTop($top)
    {
        $this->set('top', $top);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth()
    {
        return $this->get('width');
    }

    /**
     * {@inheritdoc}
     */
    public function setWidth($width)
    {
        $this->set('width', $width);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVisible()
    {
        return $this->get('visible');
    }

    /**
     * {@inheritdoc}
     */
    public function setVisible($visible)
    {
        $this->set('visible', $visible);

        return $this;
    }
}
