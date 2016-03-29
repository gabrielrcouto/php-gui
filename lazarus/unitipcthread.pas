unit UnitIpcThread;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls, Pipes,
  fpjson, jsonparser, unit1, typinfo, ExtCtrls;

type
  TIpcThread = class(TThread)
  private
    procedure CreateObject;
    procedure SetObjectProperty;
    procedure GetObjectProperty;
    procedure SetObjectEventListener;
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
   F: Text;
   jData: TJSONData;
   objArray: array of TControl;

implementation

procedure TIpcThread.CreateObject;
var obj: TControl;
  objClass: TPersistentClass;
  objIndex: Integer;
  messageId: Integer;
begin
  if (jData.FindPath('params[0].lazarusClass') <> Nil) AND (jData.FindPath('params[0].lazarusObjectId') <> Nil) then
  begin
    // The class name of the object, like TButton
    objClass := GetClass(jData.FindPath('params[0].lazarusClass').value);

    if objClass <> Nil then
    begin
      // It's a TControl?
      if objClass.InheritsFrom(TControl) then
      begin
        // Create the object, base on the class passed
        obj := TControl(TControlClass(objClass).Create(Form1));
        obj.Parent := Form1;

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
  // The Stdin Pipe
  AStream: TInputPipeStream;
  // The string returned from stdin
  AString: String;
  AStringLength: Integer;
  Counter: Integer;
  FromPosition: Integer;
  ToPosition: Integer;
begin
  // Register all the classes
  // @TODO - Move it from here!
  RegisterClass(TButton);
  RegisterClass(TEdit);
  RegisterClass(TLabel);
  RegisterClass(TShape);

  // Initializes the input pipe (Stdin)
  AStream := TInputPipeStream.Create(StdInputHandle);

  // Initializes de Stdout
  Assign(F, '');
  Rewrite(F);

  FromPosition := 1;
  ToPosition := 1;

  while Form1 = Nil do
  begin
    // Waiting Form1 be <> Nil
  end;

  SetLength(objArray, 1);
  objArray[0] := Form1;

  while True do
  begin
    // We have messages?
    if AStream.NumBytesAvailable > 0 then
    begin
      // Read the messages from buffer
      AStringLength := AStream.NumBytesAvailable; 
      SetLength(AString, AStringLength);
      AStream.ReadBuffer(AString[1], AStringLength);

      if Trim(AString) <> '' then
      begin
        // Split the AString into messages
        // Into AString, we can have more than one message, just search for "}{"
        // The "}{" into a json string is escaped by "}/{"
        for Counter := 1 to AStringLength do
        begin
          if (Counter > 1) then
          begin
            if (AString[Counter - 1] = '}') AND (AString[Counter] = '{') then
            begin
              // Ok, we found the message "glue", lets split
              ToPosition := Counter - 1;
              ParseMessage(Copy(AString, FromPosition, (ToPosition - FromPosition) + 1));
              FromPosition := Counter;
            end else if Counter = AStringLength then
            begin
              if FromPosition = 1 then
              begin
                ParseMessage(AString);
              end
              else
              begin
                // We reached the end of AString, just send the rest
                ToPosition := Counter;
                ParseMessage(Copy(AString, FromPosition, (ToPosition - FromPosition) + 1));
              end;
            end;
          end;
        end;
      end;

      FromPosition := 1;
      ToPosition := 1;
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
  Text := StringReplace(Text, '}/{', '}{', [rfReplaceAll, rfIgnoreCase]);
  jsonData := GetJSON(Text);

  jObj := TJSONObject(jsonData);
  jObj.Add('debug', true);
  Output(jObj.AsJSON);
  jObj.Free;
end;

procedure TIpcThread.ParseMessage(Text: String);
begin
  OutputDebug(Text);
  Text := StringReplace(Text, '}/{', '}{', [rfReplaceAll, rfIgnoreCase]);
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
  obj: TControl;
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

        if Assigned(propInfo) then
        begin
          obj := TControl(GetObjectProp(obj, subpropertyName));
        end else
        begin
          break;
        end;

        Delete(propertyName, 1, Pos('.', propertyName));
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
        messageId := jData.FindPath('id').AsInteger;
        Output('{"id": ' + IntToStr(messageId) + ',"result": "' + propertyValue + '"}');
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
