<?php

namespace Gui\Ipc;

/**
 * This is the IpcMap Class
 *
 * This class is used to identify the commands
 *
 * @author Rafael Reis @reisraff
 * @since 0.1
 */
abstract class IpcMap
{
    // MUST not have ROOT with value 0
    const ROOT_MESSAGE_ID_KEY = '1';
    const ROOT_METHOD_ID_KEY = '2';
    const ROOT_PARAMS_KEY = '3';
    const ROOT_RESPONSE_TYPE = '4';
    const ROOT_RESULT_VALUE = '5';
    const ROOT_RESPONSE_NOTIFICATION_EVENT_OBJECTID = '6';
    const ROOT_RESPONSE_NOTIFICATION_EVENT_EVENT = '7';
    const ROOT_DEBUG_KEY = '99';

    // MUST not have PARAMS with value 0
    const PARAMS_OBJECT_ID_KEY = '1';
    const PARAMS_OBJECT_CLASS_KEY = '2';
    const PARAMS_OBJECT_PROPERTY_NAME_KEY = '3';
    const PARAMS_OBJECT_PROPERTY_VALUE_KEY = '4';
    const PARAMS_OBJECT_METHOD_NAME_KEY = '5';
    const PARAMS_EVENT_NAME_KEY = '6';
    const PARAMS_PARENT_ID_KEY = '7';
    const PARAMS_DATA = '8';
    const PARAMS_DATA1 = '9';
    const PARAMS_DATA2 = '10';
    const PARAMS_DATA3 = '11';
    const PARAMS_DATA4 = '12';
    const PARAMS_DATA5 = '13';

    const COMMAND_METHOD_CREATE_OBJECT = 0;
    const COMMAND_METHOD_GET_OBJECT_PROPERTY = 1;
    const COMMAND_METHOD_SET_OBJECT_PROPERTY = 2;
    const COMMAND_METHOD_SET_OBJECT_EVENT_LISTENER = 3;
    const COMMAND_METHOD_CALL_OBJECT_METHOD = 4;
    const COMMAND_METHOD_DESTROY_OBJECT = 5;
    const COMMAND_METHOD_SHOW_MESSAGE = 6;
    const COMMAND_METHOD_PING = 7;

    const RESPONSE_TYPE_RESULT = 0;
    const RESPONSE_TYPE_NOTIFICATION_EVENT = 1;

    const OBJECT_METHOD_ITEMS_ADD_OBJECT = 0;
    const OBJECT_METHOD_PICTURE_BITMAP_CANVAS_SET_PIXEL = 1;
    const OBJECT_METHOD_PICTURE_BITMAP_CANVAS_PUT_IMAGE_DATA = 2;
    const OBJECT_METHOD_PICTURE_BITMAP_SET_SIZE = 3;
    const OBJECT_METHOD_ICON_LOAD_FROM_FILE = 4;
    const OBJECT_METHOD_LINES_CLEAR = 5;
    const OBJECT_METHOD_LINES_ADD = 6;
    const OBJECT_METHOD_LINES_GET_ALL = 7;
}
