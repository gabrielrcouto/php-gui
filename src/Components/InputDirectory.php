<?php
namespace Gui\Components;

/**
 * This is the Directory Input Class
 *
 * It is a visual component for select directory input.
 *
 * @link http://lazarus-ccr.sourceforge.net/docs/lcl/editbtn/tdirectoryedit.html TDirectoryEdit Reference
 * @author Everton da Rosa @everton3x
 * @since 0.1
 */
class InputDirectory extends VisualObject
{

    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TDirectoryEdit';

    /**
     * Gets the directory selected.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->get('Directory');
    }

    /**
     * Sets the title that appears on the Select Directory dialog.
     *
     * @param string $title the title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->set('DialogTitle', $title);

        return $this;
    }

    /**
     * Gets the title that appears on the Select Directory dialog.
     *
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->get('DialogTitle');
    }

    /**
     * Sets the  root directory for searching.
     *
     * @param string $path the path to directory base
     *
     * @return self
     */
    public function setBaseDir($path)
    {
        $this->set('RootDir', $path);

        return $this;
    }

    /**
     * Gets the  root directory for searching.
     *
     *
     * @return string
     */
    public function getBaseDir()
    {
        return $this->get('RootDir');
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
}
