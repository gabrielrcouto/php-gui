<?php
namespace Gui\Components;

use Gui\Color;

/**
 * This is the table class.
 *
 * It is a visual component for a table using the Lazarus
 * component TStringGrid.
 *
 * TODO: (bool) TStringGrid.Flat
 * TODO: Edit content.
 *
 * @author Isaac Skelton @kingga
 * @since 25/01/2019
 */
class Table extends VisualObject
{
    /**
     * No line around the control.
     */
    const BORDER_STYLE_NONE = 0;

    /**
     * Line around the control.
     */
    const BORDER_STYLE_SINGLE = 1;

    /** {@inheritDoc} */
    protected $lazarusClass = 'TStringGrid';

    /**
     * The alternate colour of the rows.
     *
     * @var string
     */
    protected $alternateColour;

    /**
     * The border.
     *
     * TODO: This needs to be fixed.
     *
     * @var array
     */
    protected $border;

    /**
     * The borders style, this should use one of the
     * BORDER_STYLE_* constants.
     *
     * @var integer
     */
    protected $borderStyle;

    /**
     * The column count of the table.
     *
     * @var integer
     */
    protected $colCount;

    /**
     * The row count of the table.
     *
     * @var integer
     */
    protected $rowCount;

    /** {@inheritDoc} */
    public function __construct(
        array $defaultAttributes = [],
        ContainerObjectInterface $parent = null,
        $application = null
    ) {
        parent::__construct($defaultAttributes, $parent, $application);

        // Set the default row/column count.
        $this->setRowCount(1);
        $this->setColumnCount(1);
    }

    /**
     * Set the colour of the alternating column.
     *
     * @param string $colour The hexidecimal colour.
     * @return self
     */
    public function setAlternateColor($colour)
    {
        $this->call(
            'table.setAlternateColor',
            [
                Color::toLazarus($colour),
            ]
        );
        
        $this->alternateColour = $colour;

        return $this;
    }

    /**
     * Get the colour used for the alternating column.
     *
     * @return string|null
     */
    public function getAlternateColor()
    {
        return $this->alternateColour;
    }

    /**
     * Set the border.
     *
     * @param int $top
     * @param int|null $right
     * @param int|null $bottom
     * @param int|null $left
     * @return self
     */
    public function setBorder($top, $right = null, $bottom = null, $left = null)
    {
        trigger_error('The method doesn\'t seem to be working yet.', E_USER_WARNING);

        $r = is_null($right);
        $b = is_null($bottom);
        $l = is_null($left);

        if ($r && $b && $l) {
            $right = $bottom = $left = $top;
        } elseif (!$r && $b && $l) {
            $bottom = $top;
            $left = $right;
        } elseif (!$r && !$b) {
            $left = $right;
        }

        $this->call(
            'table.setBorderSpacing',
            [
                $top,
                $right,
                $bottom,
                $left,
            ]
        );

        $this->border = [$top, $right, $bottom, $left];

        return $this;
    }

    /**
     * Get the border.
     *
     * @param boolean $withKeys Should it be returned with the keys?
     *                          e.g. $->top, $->right, $->bottom, $->left.
     * @return array|\stdClass
     */
    public function getBorder($withKeys = false)
    {
        if (!$withKeys) {
            return $this->border;
        }

        return (object) [
            'top'       => $this->border[0],
            'right'     => $this->border[1],
            'bottom'    => $this->border[2],
            'left'      => $this->border[3],
        ];
    }

    /**
     * Set the border style.
     *
     * @param integer $style Use one of the BORDER_STYLE_* constants.
     * @return self
     */
    public function setBorderStyle($style)
    {
        if ($style !== self::BORDER_STYLE_NONE && $style !== self::BORDER_STYLE_SINGLE) {
            throw new \Exception('Invalid border style used.');
        }

        $this->call(
            'table.setBorderStyle',
            [
                $style,
            ]
        );

        $this->borderStyle = $style;

        return $this;
    }

    /**
     * Set the content of the column at the given position.
     *
     * @param integer $cellx The column.
     * @param integer $celly The row.
     * @param mixed $content The content of the cell.
     * @return self
     */
    public function setContent($cellx, $celly, $content)
    {
        $this->call(
            'table.setCellContent',
            [
                $cellx,
                $celly,
                $content,
            ]
        );

        return $this;
    }

    /**
     * Set how many rows are displayed on the table.
     *
     * @param integer $count
     * @return self
     */
    public function setRowCount($count)
    {
        $this->call(
            'table.setRowCount',
            [
                $count,
            ]
        );

        $this->rowCount = $count;

        return $this;
    }

    /**
     * Get how many rows are on the table.
     *
     * @return integer
     */
    public function getRowCount()
    {
        return $this->rowCount;
    }

    /**
     * Set how many columns are on the table.
     *
     * @param integer $count
     * @return self
     */
    public function setColumnCount($count)
    {
        $this->call(
            'table.setColumnCount',
            [
                $count,
            ]
        );

        $this->colCount = $count;

        return $this;
    }

    /**
     * Get how many columns are on the table.
     *
     * @return integer
     */
    public function getColumnCount()
    {
        return $this->colCount;
    }

    /**
     * Set the default column width.
     *
     * @param integer $width
     * @return self
     */
    public function setDefaultColumnWidth($width)
    {
        $this->call(
            'table.setDefaultColumnWidth',
            [
                $width,
            ]
        );

        return $this;
    }

    /**
     * Add a column or columns to the table.
     *
     * @param integer $count The amount of columns.
     * @return self
     */
    public function addColumn($count = 1)
    {
        $this->setColumnCount($this->getColumnCount() + $count);

        return $this;
    }

    /**
     * Add a row or rows to the table.
     *
     * @param integer $count The amount of rows.
     * @return self
     */
    public function addRow($count = 1)
    {
        $this->setRowCount($this->getRowCount() + $count);

        return $this;
    }

    /**
     * Delete a column or columns from a table.
     *
     * @param integer $count The amount of columns.
     * @return self
     */
    public function deleteColumn($count = 1)
    {
        $this->addColumn(-$count);

        return $this;
    }

    /**
     * Delete a row or rows from a table.
     *
     * @param integer $count The amount of rows.
     * @return self
     */
    public function deleteRow($count = 1)
    {
        $this->addRow(-$count);

        return $this;
    }

    /**
     * Enable the table.
     *
     * @param boolean $enabled
     * @return self
     */
    public function setEnabled($enabled = true)
    {
        $this->set('Enable', $enabled);

        return $this;
    }
}
