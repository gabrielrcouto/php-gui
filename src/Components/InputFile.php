<?php
namespace Gui\Components;

use Gui\OpenOptions;

/**
 * This is the File Input Class
 *
 * It is a visual component for select file input.
 *
 * @link http://lazarus-ccr.sourceforge.net/docs/lcl/editbtn/tfilenameedit.html TFileNameEdit Reference
 * @author Everton da Rosa @everton3x
 * @since 0.1
 */
class InputFile extends VisualObject
{
    use OptionAware;

    /**
     * Dialog option to ofReadOnly.
     */
    const READ_ONLY = 'ofReadOnly';

    /**
     * Dialog option to ofOverwritePrompt.
     */
    const OVERWRITE_PROMPT = 'ofOverwritePrompt';

    /**
     * Dialog option to ofHideReadOnly.
     */
    const HIDE_READ_ONLY = 'ofHideReadOnly';

    /**
     * Dialog option to ofNoChangeDir.
     */
    const NO_CHANGE_DIR = 'ofNoChangeDir';

    /**
     * Dialog option to ofShowHelp.
     */
    const SHOW_HELP = 'ofShowHelp';

    /**
     * Dialog option to ofNoValidate.
     */
    const NO_VALIDATE = 'ofNoValidate';

    /**
     * Dialog option to ofAllowMultiSelect.
     */
    const ALLOW_MULTI_SELECT = 'ofAllowMultiSelect';

    /**
     * Dialog option to ofExtensionDifferent.
     */
    const EXTENSION_DIFFERENT = 'ofExtensionDifferent';

    /**
     * Dialog option to ofPathMustExist.
     */
    const PATH_MUST_EXIST = 'ofPathMustExist';

    /**
     * Dialog option to ofFileMustExist.
     */
    const FILE_MUST_EXIST = 'ofFileMustExist';

    /**
     * Dialog option to ofCreatePrompt.
     */
    const CREATE_PROMPT = 'ofCreatePrompt';

    /**
     * Dialog option to ofShareAware.
     */
    const SHARE_AWARE = 'ofShareAware';

    /**
     * Dialog option to ofNoReadOnlyReturn.
     */
    const NO_READ_ONLY_RETURN = 'ofNoReadOnlyReturn';

    /**
     * Dialog option to ofNoTestFileCreate.
     */
    const NO_TEST_FILE_CREATE = 'ofNoTestFileCreate';

    /**
     * Dialog option to ofNoNetworkButton.
     */
    const NO_NETWORK_BUTTON = 'ofNoNetworkButton';

    /**
     * Dialog option to ofNoLongNames.
     */
    const NO_LONG_NAMES = 'ofNoLongNames';

    /**
     * Dialog option to ofOldStyleDialog.
     */
    const OLD_STYLE_DIALOG = 'ofOldStyleDialog';

    /**
     * Dialog option to ofNoDereferenceLinks.
     */
    const NO_DEREFERENCE_LINKS = 'ofNoDereferenceLinks';

    /**
     * Dialog option to ofEnableIncludeNotify.
     */
    const ENABLE_INCLUDE_NOTIFY = 'ofEnableIncludeNotify';

    /**
     * Dialog option to ofEnableSizing.
     */
    const ENABLE_SIZING = 'ofEnableSizing';

    /**
     * Dialog option to ofDontAddToRecent.
     */
    const DONT_ADD_TO_RECENT = 'ofDontAddToRecent';

    /**
     * Dialog option to ofForceShowHidden.
     */
    const FORCE_SHOW_HIDDEN = 'ofForceShowHidden';

    /**
     * Dialog option to ofViewDetail.
     */
    const VIEW_DETAIL = 'ofViewDetail';

    /**
     * Dialog option to ofAutoPreview.
     */
    const AUTO_PREVIEW = 'ofAutoPreview';

    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TFileNameEdit';

    /**
     * Gets the files selected.
     *
     * @return array
     */
    public function getValue()
    {
        $list = explode(';', $this->get('DialogFiles'));

        array_pop($list);

        return $list;
    }

    /**
     * Sets the title that appears on the select dialog.
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
     * Gets the title that appears on the select dialog.
     *
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->get('DialogTitle');
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
        $this->set('DialogOptions', $str_options);

        return $this;
    }

    /**
     * Gets the dialog options.
     *
     * @return array the options dialog
     */
    public function getDialogOptions()
    {
        $options = $this->get('DialogOptions');

        return $this->parseOptionString($options);
    }

    /**
     * Sets the  initial directory for searching.
     *
     * @param string $path the path to base directory.
     *
     * @return self
     */
    public function setBaseDir($path)
    {
        $this->set('InitialDir', $path);

        return $this;
    }

    /**
     * Gets the  base directory for searching.
     *
     *
     * @return string
     */
    public function getBaseDir()
    {
        return $this->get('InitialDir');
    }

    /**
     * Sets filter for dialog extensions.
     *
     * @param array $extensions the extension list where key is extension (xml, json, ...)
     * and value is extension description.
     * @return self
     */
    public function setExtensionFilter($extensions)
    {
        $arr = [];

        foreach ($extensions as $ext => $desc) {
            $arr[] = "$desc|*.$ext";
        }

        $this->set('Filter', join('|', $arr));

        return $this;
    }

    /**
     * Gets filter for dialog extensions.
     *
     * @return array
     */
    public function getExtensionFilter()
    {
        $arr = explode('|', $this->get('Filter'));

        $ext_list = [];
        $descriptions = [];

        foreach ($arr as $item) {
            $test = substr($item, 0, 2);
            if ($test === '*.') {
                $ext_list[] = substr($item, 2);
            } else {
                $descriptions[] = $item;
            }
        }

        foreach ($ext_list as $key => $ext) {
            $extensions[$ext] = $descriptions[$key];
        }

        return $extensions;
    }

    /**
     * Sets to hide directory name from edit.
     *
     * @param boolean $hide
     * @return self
     */
    public function setHideDirectory($hide)
    {
        $this->set('HideDirectories', $hide);

        return $this;
    }

    /**
     * Gets if directories are omitted from edit.
     *
     * @return bool
     */
    public function isHidedirectory()
    {
        return (bool) $this->get('HideDirectories');
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
     * @return bool
     */
    public function isButtonOnlyWhenFocused()
    {
        return (bool) $this->get('ButtonOnlyWhenFocused');
    }

    /**
     * Sets if True, the edit control will select all its text when it receives focus or when the Enter key is pressed.
     *
     * @param bool $option True to activate option. False is default.
     * @return self
     */
    public function setAutoSelect($option)
    {
        $this->set('AutoSelect', $option);

        return $this;
    }

    /**
     * Gets if True, the edit control will select all its text when it receives focus or when the Enter key is pressed.
     * @return bool
     */
    public function isAutoSelect()
    {
        return (bool) $this->get('AutoSelect');
    }

    /**
     * Get number of files selected.
     *
     * @return int
     */
    public function countFiles()
    {
        return count($this->getValue());
    }
}
