<?php

namespace Gui;

use Gui\OptionMgr;

/**
 * This is the Open Dialog Options Class
 *
 * This class is used to manipulate the open dialog options
 *
 * @author Everton da Rosa @everton3x
 * @since 0.1
 */
class OpenOptions extends OptionMgr
{

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

}
