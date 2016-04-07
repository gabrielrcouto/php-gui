unit UnitIpcThread;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls, Pipes,
  fpjson, jsonparser, unit1, typinfo, ExtCtrls, Variants;

type
  TIpcThread = class(TThread)
  private
    procedure CreateObject;
    procedure SetObjectProperty;
    procedure GetObjectProperty;
    procedure SetObjectEventListener;
    procedure CallObjectMethod;
    procedure Ping;
    procedure OutputDebug(Text: String);
  protected
    procedure Execute; override;
    procedure Output(Text: String);
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

implementation

procedure TIpcThread.CreateObject;
var obj: TControl;
  objClass: TPersistentClass;
  objIndex: Integer;
  parent: Integer;
  messageId: Integer;
begin
  if (jData.FindPath('params[0].lazarusClass') <> Nil) AND (jData.FindPath('params[0].lazarusObjectId') <> Nil) AND (jData.FindPath('params[0].parent') <> Nil) then
  begin
    // The class name of the object, like TButton
    objClass := GetClass(jData.FindPath('params[0].lazarusClass').value);

    if objClass <> Nil then
    begin
      // It's a TControl?
      if objClass.InheritsFrom(TControl) then
      begin

        if jData.FindPath('params[0].lazarusClass').AsString = 'TForm1' then
        begin
            Application.CreateForm(TForm1, obj);
            (obj as TForm1).Show;
        end
        else
        begin
          // Create the object, base on the class passed

          parent := jData.FindPath('params[0].parent').AsInteger;

          obj := TControl(TControlClass(objClass).Create(objArray[parent]));
          obj.Parent := TWinControl(objArray[parent]);
        end;

        // The index of the object on the object array
        objIndex := jData.FindPath('params[0].lazarusObjectId').AsInteger;

        // We need to alocate more space on the object array?
        if Length(objArray) <= objIndex then
        begin
          SetLength(objArray, objIndex + 1);
        end;

        objArray[objIndex] := obj;

        // If it's a command, reply to it
        if (jData.FindPath('id') <> Nil) then
        begin
             messageId := jData.FindPath('id').AsInteger;
             Output('{"id": ' + IntToStr(messageId) + ', "result": ' + IntToStr(objIndex) + '}');
        end;
      end;
    end;
  end;
end;

procedure TIpcThread.Output(Text: String);
begin
  Write(F, Text);
  Flush(F);
end;

procedure TIpcThread.Execute;
var
  // The cumulative Stdin string buffer
  StdinStringBuffer: String;
  // The Stdin Pipe
  StdinStream: TInputPipeStream;
  // The string returned from stdin
  StdinString: String;
  StdinStringLength: LongInt;

  Counter: Integer;
  CurrentPos: Integer;

  OpeningBraces: Integer;
  ClosingBraces: Integer;
  DoubleQuotes: Integer;
  FirstOpeningBracePos: Integer;
begin
  // Register all the classes
  // @TODO - Move it from here!
  RegisterClass(TForm1);
  RegisterClass(TButton);
  RegisterClass(TEdit);
  RegisterClass(TLabel);
  RegisterClass(TShape);
  RegisterClass(TCheckBox);
  RegisterClass(TRadioGroup);
  RegisterClass(TBitmap);
  RegisterClass(TImage);
  RegisterClass(TScrollBox);
  RegisterClass(TComboBox);
  RegisterClass(TMemo);

  // Initializes the input pipe (Stdin)
  StdinStream := TInputPipeStream.Create(StdInputHandle);
  // The buffer starts empty
  StdinStringBuffer := '';

  // Initializes de Stdout
  Assign(F, '');
  Rewrite(F);

  OpeningBraces := 0;
  ClosingBraces := 0;
  DoubleQuotes := 0;
  FirstOpeningBracePos := 1;

  while Form1 = Nil do
  begin
    // Waiting Form1 be <> Nil
    Sleep(1);
  end;

  // The Form1 needs to be the first object on objArray
  SetLength(objArray, 1);
  objArray[0] := Form1;

  while True do
  begin
    // OutputDebug('{"waiting": true}');

    // We have messages?
    if StdinStream.NumBytesAvailable > 0 then
    begin
      // Read the messages from stdin stream
      SetLength(StdinString, StdinStream.NumBytesAvailable);
      StdinStream.Read(StdinString[1], StdinStream.NumBytesAvailable);

      // Add the new stdin to the buffer
      StdinStringBuffer := StdinStringBuffer + StdinString;

      if StdinStringBuffer <> '' then
      begin
        // Split the StdinStringBuffer into messages
        // Into StdinStringBuffer, we can have more than one message, just count the { and }
        // When we have the same number of { and }, it's a complete JSON message
        CurrentPos := 1;

        for Counter := 1 to Length(StdinStringBuffer) do
        begin

          // Count how many { or } we have into the string
          if (StdinStringBuffer[CurrentPos] = '{') and (DoubleQuotes mod 2 = 0) then
          begin
            Inc(OpeningBraces);

            if OpeningBraces = 1 then
            begin
              FirstOpeningBracePos := CurrentPos;
            end;
          end 
          else if (StdinStringBuffer[CurrentPos] = '}') and (DoubleQuotes mod 2 = 0) then
          begin
            Inc(ClosingBraces);
          end
          else if (StdinStringBuffer[CurrentPos] = '"') and ((CurrentPos = 1) or (StdinStringBuffer[CurrentPos - 1] <> '\\')) then
          begin
            Inc(DoubleQuotes);
          end;

          // We have a full JSON message
          if (OpeningBraces > 0) AND (OpeningBraces = ClosingBraces) then
          begin
            // Parse the message
            ParseMessage(Copy(StdinStringBuffer, FirstOpeningBracePos, CurrentPos));

            // Remove the message from the buffer
            Delete(StdinStringBuffer, FirstOpeningBracePos, CurrentPos);

            CurrentPos := 1;
            
            OpeningBraces := 0;
            ClosingBraces := 0;
            DoubleQuotes := 0;
            FirstOpeningBracePos := 1;
          end
          else
          begin
            Inc(CurrentPos);
          end;
        end;

        CurrentPos := 1;
            
        OpeningBraces := 0;
        ClosingBraces := 0;
        DoubleQuotes := 0;
      end;
    end
    else
    begin
      Sleep(1);
    end;
  end;
end;

procedure TIpcThread.OutputDebug(Text: String);
var
  jsonData : TJSONData;
  jObj : TJSONObject;
begin
  jsonData := GetJSON(Text);

  jObj := TJSONObject(jsonData);
  jObj.Add('debug', true);
  Output(jObj.AsJSON);
  jObj.Free;
end;

procedure TIpcThread.ParseMessage(Text: String);
begin
  // OutputDebug(Text);

  jData := GetJSON(Text);
  // All messages need a method
  if (jData.FindPath('method') <> Nil) then
  begin
    // Find the corret function for the method
    // Because we will modify the GUI, we need to Synchronize this thread with the GUI thread
    if (jData.FindPath('method').value = 'createObject') then
    begin
      Synchronize(@CreateObject);
    end else if (jData.FindPath('method').value = 'setObjectEventListener') then
    begin
      Synchronize(@SetObjectEventListener);
    end else if (jData.FindPath('method').value = 'setObjectProperty') then
    begin
      Synchronize(@SetObjectProperty);
    end else if (jData.FindPath('method').value = 'getObjectProperty') then
    begin
      Synchronize(@GetObjectProperty);
    end else if (jData.FindPath('method').value = 'callObjectMethod') then
    begin
      Synchronize(@CallObjectMethod);
    end else if (jData.FindPath('method').value = 'ping') then
    begin
      Synchronize(@Ping);
    end;
  end;
end;

procedure TIpcThread.Ping;
var
  messageId: Integer;
  microtime: String;
begin
  messageId := jData.FindPath('id').AsInteger;
  microtime := jData.FindPath('params[0]').AsString;

  Output('{"id": ' + IntToStr(messageId) + ', "result": "' + microtime + '"}');
end;

procedure TIpcThread.CallObjectMethod;
var
  messageId: Integer;
  messageMethodName: String;
  objId: Integer;
  intCtrl: array of Integer;
  strCtrl: array of String;
  sent: Boolean;
  counter: Integer;
begin
  if (jData.FindPath('params[0]') <> Nil) AND (jData.FindPath('params[1]') <> Nil) AND (jData.FindPath('params[2]') <> Nil) then
  begin
    objId := jData.FindPath('params[0]').AsInteger;
    messageMethodName := jData.FindPath('params[1]').AsString;

    if messageMethodName = 'items.addObject' then
    begin

      SetLength(strCtrl, 1);
      SetLength(intCtrl, 1);

      strCtrl[0] := jData.FindPath('params[2][0]').AsString;
      intCtrl[0] := jData.FindPath('params[2][1]').AsInteger;

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
    end
    else if messageMethodName = 'picture.bitmap.canvas.setPixel' then
    begin
      (objArray[objId] as TImage).Picture.Bitmap.Canvas.Pixels[jData.FindPath('params[2][0]').AsInteger, jData.FindPath('params[2][1]').AsInteger] := jData.FindPath('params[2][2]').AsInteger;
    end
    else if messageMethodName = 'picture.bitmap.setSize' then
    begin
      (objArray[objId] as TImage).Picture.Bitmap.SetSize(jData.FindPath('params[2][0]').AsInteger,jData.FindPath('params[2][1]').AsInteger);
    end
    else if messageMethodName = 'icon.loadFromFile' then
    begin
      (objArray[objId] as TForm1).Icon.LoadFromFile(jData.FindPath('params[2][0]').AsString);
    end
    else if messageMethodName = 'lines.clear' then
    begin
      (objArray[objId] as TMemo).Lines.Clear;
    end
    else if messageMethodName = 'lines.add' then
    begin
      (objArray[objId] as TMemo).Lines.Add(jData.FindPath('params[2][0]').AsString);
    end
    else if messageMethodName = 'lines.getAll' then
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
          strCtrl[0] := strCtrl[0] + '\n' + (objArray[objId] as TMemo).Lines.Strings[counter]
        end;;
      end;

      messageId := jData.FindPath('id').AsInteger;
      Output('{"id": ' + IntToStr(messageId) + ', "result": "' + strCtrl[0] + '"}');
      sent := true;
    end;

    // If it's a command, reply to it
    if (jData.FindPath('id') <> Nil) AND (sent = false) then
    begin
         messageId := jData.FindPath('id').AsInteger;
         Output('{"id": ' + IntToStr(messageId) + ', "result": ' + IntToStr(objId) + '}');
    end;
  end;
end;

procedure TIpcThread.SetObjectEventListener;
var objId: Integer;
  eventHandler: TEventHandler;
  eventName: String;
  propInfo: PPropInfo;
begin
  // param[0] = objectId
  // param[1] = eventName
  if (jData.FindPath('params[0]') <> Nil) AND (jData.FindPath('params[1]') <> Nil) then
  begin
    // check if objectId is valid
    if jData.FindPath('params[0]').AsInteger < Length(objArray) then
    begin
      objId := jData.FindPath('params[0]').AsInteger;
      eventName := jData.FindPath('params[1]').AsString;

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
end;

procedure TIpcThread.SetObjectProperty;
var  objId: Integer;
  obj: TObject;
  propertyName: String;
  propertyValue: Variant;
  propInfo: PPropInfo;
  subpropertyName: String;
begin
  // param[0] = objectId
  // param[1] = propertyName
  // param[2] = propertyValue
  if (jData.FindPath('params[0]') <> Nil) AND (jData.FindPath('params[1]') <> Nil) AND (jData.FindPath('params[2]') <> Nil) then
  begin
    // check if objectId is valid
    if jData.FindPath('params[0]').AsInteger < Length(objArray) then
    begin
      objId := jData.FindPath('params[0]').AsInteger;
      obj := objArray[objId];
      propertyName := jData.FindPath('params[1]').AsString;
      propertyValue := jData.FindPath('params[2]').Value;

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
  // param[0] = objectId
  // param[1] = propertyName
  if (jData.FindPath('params[0]') <> Nil) AND (jData.FindPath('params[1]') <> Nil) then
  begin
    // check if objectId is valid
    if jData.FindPath('params[0]').AsInteger < Length(objArray) then
    begin
      objId := jData.FindPath('params[0]').AsInteger;
      propertyName := jData.FindPath('params[1]').AsString;

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

        messageId := jData.FindPath('id').AsInteger;
        Output('{"id": ' + IntToStr(messageId) + ',"result": ' + return + '}');
      end;
    end;
  end;
end;

procedure TEventHandler.Call(Sender: TObject);
var i: Integer;
begin
  for i := 0 to Length(objArray) do
  begin
    if objArray[i] = Sender then
    begin
      Output('{"method": "callObjectEventListener", "params": [' + IntToStr(ObjectId) + ', "' + EventName + '"]}');
    end;
  end;
end;

procedure TEventHandler.Output(Text: String);
begin
  Write(F, Text);
  Flush(F);
end;

end.
