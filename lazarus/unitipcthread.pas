unit UnitIpcThread;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls, Pipes,
  fpjson, jsonparser, unit1, typinfo, ExtCtrls, Variants;

type

  { TIpcThread }

  TIpcThread = class(TThread)
  private
    procedure CreateObject;
    procedure DestroyObject;
    procedure SetObjectProperty;
    procedure GetObjectProperty;
    procedure SetObjectEventListener;
    procedure CallObjectMethod;
    procedure Ping;
    procedure ShowMessage;
    procedure OutputDebug(Text: String);
  protected
    procedure Execute; override;
    procedure Output(Text: String);
    procedure ProcessMessages();
    procedure ParseMessage(Text: String);
  public
  end;

type
  TEventHandler = class(TObject)
  private
  protected
  public
    EventName: String;
    ObjectId: Integer;
    procedure Call(Sender: TObject);
    procedure Output(Text: String);
  end;

var
  B: String;
  F: Text;
  jData: TJSONData;
  objArray: array of TControl;
  // The cumulative Stdin string buffer
  StdinStringBuffer: String;

const
  ROOT_MESSAGE_ID_KEY = '1';
  ROOT_METHOD_ID_KEY = '2';
  ROOT_PARAMS_KEY = '3';
  ROOT_RESPONSE_TYPE = '4';
  ROOT_RESULT_VALUE = '5';
  ROOT_RESPONSE_NOTIFICATION_EVENT_OBJECTID = '6';
  ROOT_RESPONSE_NOTIFICATION_EVENT_EVENT = '7';
  ROOT_DEBUG_KEY = '99';

  PARAMS_OBJECT_ID_KEY = '1';
  PARAMS_OBJECT_CLASS_KEY = '2';
  PARAMS_OBJECT_PROPERTY_NAME_KEY = '3';
  PARAMS_OBJECT_PROPERTY_VALUE_KEY = '4';
  PARAMS_OBJECT_METHOD_NAME_KEY = '5';
  PARAMS_EVENT_NAME_KEY = '6';
  PARAMS_PARENT_ID_KEY = '7';
  PARAMS_DATA = '8';
  PARAMS_DATA1 = '9';
  PARAMS_DATA2 = '10';
  PARAMS_DATA3 = '11';
  PARAMS_DATA4 = '12';
  PARAMS_DATA5 = '13';

  COMMAND_METHOD_CREATE_OBJECT = 0;
  COMMAND_METHOD_GET_OBJECT_PROPERTY = 1;
  COMMAND_METHOD_SET_OBJECT_PROPERTY = 2;
  COMMAND_METHOD_SET_OBJECT_EVENT_LISTENER = 3;
  COMMAND_METHOD_CALL_OBJECT_METHOD = 4;
  COMMAND_METHOD_DESTROY_OBJECT = 5;
  COMMAND_METHOD_SHOW_MESSAGE = 6;
  COMMAND_METHOD_PING = 7;

  RESPONSE_TYPE_RESULT = 0;
  RESPONSE_TYPE_NOTIFICATION_EVENT = 1;

  TOBJECT_KEY = 0;
  TFORM1_KEY = 1;
  TBUTTON_KEY = 2;
  TIMAGE_KEY = 3;
  TCHECKBOX_KEY = 4;
  TSCROLLBOX_KEY = 5;
  TEDIT_KEY = 6;
  TLABEL_KEY = 7;
  TRADIOGROUP_KEY = 8;
  TCOMBOBOX_KEY = 9;
  TSHAPE_KEY = 10;
  TMEMO_KEY = 11;

  OBJECT_METHOD_ITEMS_ADD_OBJECT = 0;
  OBJECT_METHOD_PICTURE_BITMAP_CANVAS_SET_PIXEL = 1;
  OBJECT_METHOD_PICTURE_BITMAP_CANVAS_PUT_IMAGE_DATA = 2;
  OBJECT_METHOD_PICTURE_BITMAP_SET_SIZE = 3;
  OBJECT_METHOD_ICON_LOAD_FROM_FILE = 4;
  OBJECT_METHOD_LINES_CLEAR = 5;
  OBJECT_METHOD_LINES_ADD = 6;
  OBJECT_METHOD_LINES_GET_ALL = 7;

implementation



procedure TIpcThread.Execute;
var
  // The Stdin Pipe
  StdinStream: TInputPipeStream;
  // The string returned from stdin
  StdinString: String;
  LastTimestamp: TTimeStamp;
  CurrentTimestamp: TTimeStamp;
  BytesAvailable: Integer;
begin
  // Register all the classes
  // @TODO - Move it from here!
  RegisterClass(TForm1);
  RegisterClass(TButton);
  RegisterClass(TImage);
  RegisterClass(TCheckBox);
  RegisterClass(TScrollBox);
  RegisterClass(TEdit);
  RegisterClass(TLabel);
  RegisterClass(TRadioGroup);
  RegisterClass(TComboBox);
  RegisterClass(TShape);
  RegisterClass(TMemo);
  RegisterClass(TBitmap);

  // Initializes the input pipe (Stdin)
  StdinStream := TInputPipeStream.Create(StdInputHandle);
  // The buffer starts empty
  StdinStringBuffer := '';

  // Initializes de Stdout
  Assign(F, '');
  Rewrite(F);

  while Form1 = Nil do
  begin
    // Waiting Form1 be <> Nil
    Sleep(1);
  end;

  // The Form1 needs to be the first object on objArray
  SetLength(objArray, 1);
  objArray[0] := Form1;

  LastTimestamp := DateTimeToTimeStamp(Now);
  
  SetLength(StdinString, 1);

  while True do
  begin
    // OutputDebug('{"waiting": true}');

    BytesAvailable := StdinStream.NumBytesAvailable;

    // We have messages?
    if BytesAvailable > 0 then
    begin
      SetLength(StdinString, BytesAvailable);
      // Read the messages from stdin stream
      StdinStream.ReadBuffer(StdinString[1], BytesAvailable);

      // Add the new stdin to the buffer
      StdinStringBuffer := Concat(StdinStringBuffer, StdinString);
    end;

    CurrentTimestamp := DateTimeToTimeStamp(Now);

    // 60fps = one frame after 16ms
    if (StdinStringBuffer <> '') and (CurrentTimestamp.Time - LastTimestamp.Time > 16) then
    begin
      LastTimestamp := CurrentTimestamp;
      Synchronize(@ProcessMessages);
    end;
  end;
end;

procedure TIpcThread.ProcessMessages();
var
  CurrentPos: Integer;
begin
  CurrentPos := Pos(#0, StdinStringBuffer);

  while CurrentPos > 0 do
  begin
    // Parse the message
    ParseMessage(Copy(StdinStringBuffer, 1, CurrentPos));

    // Remove the message from the buffer
    Delete(StdinStringBuffer, 1, CurrentPos);

    CurrentPos := Pos(#0, StdinStringBuffer);
  end;
end;

procedure TIpcThread.ParseMessage(Text: String);
begin
  jData := GetJSON(Text);

  if (jData.FindPath(ROOT_METHOD_ID_KEY) <> Nil) then
  begin

    case jData.FindPath(ROOT_METHOD_ID_KEY).AsInteger of
      COMMAND_METHOD_CREATE_OBJECT : CreateObject;
      COMMAND_METHOD_DESTROY_OBJECT : DestroyObject;
      COMMAND_METHOD_GET_OBJECT_PROPERTY : GetObjectProperty;
      COMMAND_METHOD_SET_OBJECT_PROPERTY : SetObjectProperty;
      COMMAND_METHOD_SET_OBJECT_EVENT_LISTENER : SetObjectEventListener;
      COMMAND_METHOD_CALL_OBJECT_METHOD : CallObjectMethod;
      COMMAND_METHOD_SHOW_MESSAGE : ShowMessage;
      COMMAND_METHOD_PING : Ping;
    end;

  end;
end;

procedure TIpcThread.Output(Text: String);
begin
  Write(F, Text + #0);
  Flush(F);
end;

procedure TIpcThread.OutputDebug(Text: String);
var
  jsonData : TJSONData;
  jObj : TJSONObject;
begin
  jsonData := GetJSON(Text);

  jObj := TJSONObject(jsonData);
  jObj.Add(ROOT_DEBUG_KEY, 1);
  Output(jObj.AsJSON);
  jObj.Free;
end;

procedure TIpcThread.CreateObject;
var obj: TControl;
  objClassId: Integer;
  objClass: TPersistentClass;
  objIndex: Integer;
  parent: Integer;
  messageId: Integer;
  objName: String;
begin
  objClassId := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_OBJECT_CLASS_KEY).AsInteger;

  objName := '';
  case objClassId of
    TOBJECT_KEY : objName := 'TObject';
    TFORM1_KEY : objName := 'TForm1';
    TBUTTON_KEY : objName := 'TButton';
    TIMAGE_KEY : objName := 'TImage';
    TCHECKBOX_KEY : objName := 'TCheckBox';
    TSCROLLBOX_KEY : objName := 'TScrollBox';
    TEDIT_KEY : objName := 'TEdit';
    TLABEL_KEY : objName := 'TLabel';
    TRADIOGROUP_KEY : objName := 'TRadioGroup';
    TCOMBOBOX_KEY : objName := 'TComboBox';
    TSHAPE_KEY : objName := 'TShape';
    TMEMO_KEY : objName := 'TMemo';
  end;

  objClass := GetClass(objName);

  if objClassId = TFORM1_KEY then
  begin
      Application.CreateForm(TForm1, obj);
      (obj as TForm1).Show;
  end
  else
  begin
    // Create the object, base on the class passed
    parent := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_PARENT_ID_KEY).AsInteger;
    obj := TControl(TControlClass(objClass).Create(objArray[parent]));
    obj.Parent := TWinControl(objArray[parent]);
  end;

  // The index of the object on the object array
  objIndex := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_OBJECT_ID_KEY).AsInteger;

  // We need to alocate more space on the object array?
  if Length(objArray) <= objIndex then
  begin
    SetLength(objArray, objIndex + 1);
  end;

  objArray[objIndex] := obj;

  // If it's a command, reply to it
   messageId := jData.FindPath(ROOT_MESSAGE_ID_KEY).AsInteger;
   Output('{'
    + '"' + ROOT_MESSAGE_ID_KEY + '":' + IntToStr(messageId) + ','
    + '"' + ROOT_RESPONSE_TYPE + '":' + IntToStr(RESPONSE_TYPE_RESULT) + ','
    + '"' + ROOT_RESULT_VALUE + '":' + IntToStr(objIndex)
    + '}');

end;

procedure TIpcThread.DestroyObject;
var obj: TControl;
  objId: Integer;
  messageId: Integer;
begin
  objId := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_OBJECT_ID_KEY).AsInteger;
  if (objId < Length(objArray)) then
  begin
    obj := objArray[objId];

    FreeAndNil(obj);

    messageId := jData.FindPath(ROOT_MESSAGE_ID_KEY).AsInteger;
    Output('{'
      + '"' + ROOT_MESSAGE_ID_KEY + '":' + IntToStr(messageId) + ','
      + '"' + ROOT_RESPONSE_TYPE + '":' + IntToStr(RESPONSE_TYPE_RESULT) + ','
      + '"' + ROOT_RESULT_VALUE + '":' + IntToStr(objId)
      + '}');

  end;
end;

procedure TIpcThread.CallObjectMethod;
var
  messageId: Integer;
  messageMethodName: Integer;
  objId: Integer;
  intCtrl: array of Integer;
  strCtrl: array of String;
  sent: Boolean;
  counter: Integer;
  max: Integer;
  x: Integer;
  y: Integer;
  resultValue: String;
begin

  objId := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_OBJECT_ID_KEY).AsInteger;
  resultValue := IntToStr(objId);

  case jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_OBJECT_METHOD_NAME_KEY).AsInteger of
    OBJECT_METHOD_ITEMS_ADD_OBJECT :
    begin
      SetLength(strCtrl, 1);
      SetLength(intCtrl, 1);

      strCtrl[0] := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA).AsString;
      intCtrl[0] := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA1).AsInteger;

      if objArray[objId].InheritsFrom(TRadioGroup) then
      begin
        (objArray[objId] as TRadioGroup).Items.AddObject(
          strCtrl[0],
          TObject(PtrUint(intCtrl[0]))
        );
      end
      else
      begin
        (objArray[objId] as TComboBox).Items.AddObject(
          strCtrl[0],
          TObject(PtrUint(intCtrl[0]))
        );
      end;
    end;
    OBJECT_METHOD_PICTURE_BITMAP_CANVAS_SET_PIXEL :
    begin
      (objArray[objId] as TImage)
        .Picture
        .Bitmap
        .Canvas
        .Pixels[
          jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA).AsInteger,
          jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA1).AsInteger] := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA2).AsInteger;
    end;
    OBJECT_METHOD_PICTURE_BITMAP_CANVAS_PUT_IMAGE_DATA :
    begin
      counter := 0;
      max := (jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA) as TJSONArray).Count;

      for x := 0 to (objArray[objId] as TImage).Picture.Bitmap.Width - 1 do
      begin
        for y := 0 to (objArray[objId] as TImage).Picture.Bitmap.Height - 1 do
        begin
          if counter < max then
          begin
            (objArray[objId] as TImage)
              .Picture
              .Bitmap
              .Canvas
              .Pixels[x, y] := (jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA) as TJSONArray).Integers[counter];
          end;

          Inc(counter);
        end;
      end;
    end;
    OBJECT_METHOD_PICTURE_BITMAP_SET_SIZE :
    begin
      (objArray[objId] as TImage)
        .Picture
        .Bitmap
        .SetSize(
          jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA).AsInteger,
          jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA1).AsInteger
        );
    end;
    OBJECT_METHOD_ICON_LOAD_FROM_FILE :
    begin
      (objArray[objId] as TForm1)
        .Icon
        .LoadFromFile(jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA).AsString);
    end;
    OBJECT_METHOD_LINES_CLEAR :
    begin
      (objArray[objId] as TMemo).Lines.Clear;
    end;
    OBJECT_METHOD_LINES_ADD :
    begin
      (objArray[objId] as TMemo)
        .Lines
        .Add(jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA).AsString);
    end;
    OBJECT_METHOD_LINES_GET_ALL :
    begin
      SetLength(strCtrl, 1);
      SetLength(intCtrl, 1);

      // The index 0 will be the string to be sent
      strCtrl[0] := '';
      intCtrl[0] := (objArray[objId] as TMemo).Lines.Count - 1;

      for counter := 0 to intCtrl[0] do
      begin
        if (counter = 0) then
        begin
          strCtrl[0] := (objArray[objId] as TMemo).Lines.Strings[counter];
        end
        else
        begin
          strCtrl[0] := strCtrl[0] + '\n' + (objArray[objId] as TMemo).Lines.Strings[counter];
        end;
      end;
      resultValue := '"' + strCtrl[0] + '"';
    end;
  end;

  messageId := jData.FindPath(ROOT_MESSAGE_ID_KEY).AsInteger;
  Output('{'
    + '"' + ROOT_MESSAGE_ID_KEY + '":' + IntToStr(messageId) + ','
    + '"' + ROOT_RESPONSE_TYPE + '":' + IntToStr(RESPONSE_TYPE_RESULT) + ','
    + '"' + ROOT_RESULT_VALUE + '":' + resultValue
    + '}');
end;

procedure TIpcThread.SetObjectEventListener;
var objId: Integer;
  eventHandler: TEventHandler;
  eventName: String;
  propInfo: PPropInfo;
begin
  // check if objectId is valid
  objId := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_OBJECT_ID_KEY).AsInteger;
  if objId < Length(objArray) then
  begin
    eventName := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_EVENT_NAME_KEY).AsString;

    // Get the info about the property
    propInfo := GetPropInfo(objArray[objId], eventName);

    // If the object has the property, change the value
    if Assigned(propInfo) then
    begin
      eventHandler := TEventHandler.Create;
      eventHandler.EventName := eventName;
      eventHandler.ObjectId := objId;
      SetMethodProp(objArray[objId], eventName, TMethod(@eventHandler.Call));
    end;
  end;
end;

procedure TIpcThread.SetObjectProperty;
var  objId: Integer;
  obj: TObject;
  propertyName: String;
  propertyValue: Variant;
  propInfo: PPropInfo;
  subpropertyName: String;
begin
  objId := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_OBJECT_ID_KEY).AsInteger;
  obj := objArray[objId];
  propertyName := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_OBJECT_PROPERTY_NAME_KEY).AsString;
  propertyValue := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_OBJECT_PROPERTY_VALUE_KEY).AsString;

  // The property name can be property.subproperty.subsubproperty...
  while Pos('.', propertyName) > 0 do
  begin
    subpropertyName := Copy(propertyName, 1, Pos('.', propertyName) - 1);
    propInfo := GetPropInfo(obj, subpropertyName);
    Delete(propertyName, 1, Pos('.', propertyName));

    if Assigned(propInfo) then
    begin
      obj := GetObjectProp(obj, subpropertyName);
    end else
    begin
      break;
    end;
  end;

  // Get the info about the property
  propInfo := GetPropInfo(obj, propertyName);

  // If the object has the property, change the value
  if Assigned(propInfo) then
  begin
    // @TODO: Convert propertyValue to a object checking with PropIsType and GetObjectPropClass
    SetPropValue(obj, propertyName, propertyValue);
  end;
end;

procedure TIpcThread.GetObjectProperty;
var  objId: Integer;
  propertyName: String;
  propertyValue: Variant;
  propInfo: PPropInfo;
  messageId: Integer;
  return: String;
begin
  // check if objectId is valid
  objId := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_OBJECT_ID_KEY).AsInteger;
  if objId < Length(objArray) then
  begin
    propertyName := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_OBJECT_PROPERTY_NAME_KEY).AsString;

    // Get the info about the property
    propInfo := GetPropInfo(objArray[objId], propertyName);

    // If the object has the property, change the value
    if Assigned(propInfo) then
    begin

      // @todo send the Variant property as your real type
      propertyValue := GetPropValue(objArray[objId], propertyName, true);

      if VarIsStr(propertyValue) then
      begin
        return := '"' + VarToStr(propertyValue) + '"';
      end
      else
      begin
        return := VarToStr(propertyValue);
      end;

      messageId := jData.FindPath(ROOT_MESSAGE_ID_KEY).AsInteger;
      Output('{'
        + '"' + ROOT_MESSAGE_ID_KEY + '":' + IntToStr(messageId) + ','
        + '"' + ROOT_RESPONSE_TYPE + '":' + IntToStr(RESPONSE_TYPE_RESULT) + ','
        + '"' + ROOT_RESULT_VALUE + '":' + return
        + '}');
    end;
  end;
end;

procedure TIpcThread.ShowMessage;
var
  Title,
  Message : string;
begin
  if (jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA1) <> Nil) AND (jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA1).AsString <> '') then
  begin
    Title := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA1).AsString;
  end
  else
  begin
    Title := Application.MainForm.Caption;
  end;
  Message := StringReplace(jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA).AsString, '\n', sLineBreak, [rfReplaceAll] );
  Application.MessageBox( @Message[1], @Title[1] );
end;

procedure TIpcThread.Ping;
var
  messageId: Integer;
  microtime: String;
begin
  messageId := jData.FindPath(ROOT_MESSAGE_ID_KEY).AsInteger;
  microtime := jData.FindPath(ROOT_PARAMS_KEY + '.' + PARAMS_DATA).AsString;

  Output('{'
    + '"' + ROOT_MESSAGE_ID_KEY + '":' + IntToStr(messageId) + ','
    + '"' + ROOT_RESPONSE_TYPE + '":' + IntToStr(RESPONSE_TYPE_RESULT) + ','
    + '"' + ROOT_RESULT_VALUE + '":"' + microtime + '"'
    + '}');
end;

procedure TEventHandler.Call(Sender: TObject);
var i: Integer;
begin
  for i := 0 to Length(objArray) do
  begin
    if objArray[i] = Sender then
    begin
      Output('{'
        + '"' + ROOT_RESPONSE_TYPE + '":' + IntToStr(RESPONSE_TYPE_NOTIFICATION_EVENT) + ','
        + '"' + ROOT_RESPONSE_NOTIFICATION_EVENT_OBJECTID + '":' + IntToStr(ObjectId) + ','
        + '"' + ROOT_RESPONSE_NOTIFICATION_EVENT_EVENT + '":"' + EventName + '"'
        + '}');
    end;
  end;
end;

procedure TEventHandler.Output(Text: String);
begin
  Write(F, Text + #0);
  Flush(F);
end;

end.
