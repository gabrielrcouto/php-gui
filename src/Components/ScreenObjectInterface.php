<?php

namespace Gui\Components;

interface ScreenObjectInterface
{
    public function getAutoSize();
    public function setAutoSize($autoSize);
    public function getBackgroundColor();
    public function setBackgroundColor($color);
    public function getBottom();
    public function setBottom($bottom);
    public function getHeight();
    public function setHeight($height);
    public function getLeft();
    public function setLeft($left);
    public function getRight();
    public function setRight($right);
    public function getTop();
    public function setTop($top);
    public function getWidth();
    public function setWidth($width);
    public function getVisible();
    public function setVisible($visible);
}
