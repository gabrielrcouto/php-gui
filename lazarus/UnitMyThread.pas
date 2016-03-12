unit UnitMyThread;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls, Pipes,
  fpjson, jsonparser, unit1, typinfo;

type
  TMyThread = class(TThread)
  private
    procedure CreateObject;
    procedure SetObjectProperty;
  protected
    procedure Execute; override;
    procedure Output(Text: String);
    procedure ParseMessage(Text: String);
  public
  end;

var
   F: Text;
   jData: TJSONData;
   objArray: array of TControl;

implementation

procedure TMyThread.CreateObject;
var obj: TControl;
  objClass: TPersistentClass;
  objIndex: Integer;
  messageId: Integer;
begin
  if jData.FindPath('params[0].lazarusClass') <> Nil then
  begin
    objClass := GetClass(jData.FindPath('params[0].lazarusClass').value);

    if objClass <> Nil then
    begin
      if objClass.InheritsFrom(TControl) then
      begin
        obj := TControl(TControlClass(objClass).Create(Form1));
        obj.Parent := Form1;
        objIndex := Length(objArray);
        SetLength(objArray, objIndex + 1);
        objArray[objIndex] := obj;

        // obj.Caption := 'Ok';
        // obj.SetBounds(10,10,200,30);

        if (jData.FindPath('id') <> Nil) then
        begin
             messageId := jData.FindPath('id').AsInteger;
             Output('{"id": ' + IntToStr(messageId) + ', "result": ' + IntToStr(objIndex) + '}');
        end;
      end;
    end;
  end;
end;

procedure TMyThread.Output(Text: String);
begin
  Write(F, Text);
  Flush(F);
end;

procedure TMyThread.Execute;
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

  // Initializes the input pipe (Stdin)
  AStream := TInputPipeStream.Create(StdInputHandle);

  // Initializes de Stdout
  Assign(F, '');
  Rewrite(F);

  FromPosition := 1;
  ToPosition := 1;

  while True do
  begin
    // We have messages?
    if AStream.NumBytesAvailable > 0 then
    begin
      // Read the messages from buffer
      AStringLength := AStream.NumBytesAvailable; 
      SetLength(AString, AStringLength);
      AStream.ReadBuffer(AString[1], AStringLength);

      // Split the AString into messages
      for Counter := 1 to AStringLength do
      begin
        if (Counter > 1) then
        begin
          if (AString[Counter - 1] = '}') AND (AString[Counter] = '{') then
          begin
            ToPosition := Counter - 1;
            ParseMessage(Copy(AString, FromPosition, (ToPosition - FromPosition) + 1));
            FromPosition := Counter;
          end else if Counter = AStringLength then
          begin
            ToPosition := Counter;
            ParseMessage(Copy(AString, FromPosition, (ToPosition - FromPosition) + 1));
          end;
        end;
      end;
    end
    else
    begin
      Sleep(1);
    end;
  end;
end;

procedure TMyThread.ParseMessage(Text: String);
begin
  Output('Get: ' + Text);
  Text := StringReplace(Text, '}/{', '}{', [rfReplaceAll, rfIgnoreCase]);
  jData := GetJSON(Text);

  if (jData.FindPath('method') <> Nil) then
  begin
    if (jData.FindPath('method').value = 'createObject') then
    begin
      Synchronize(@CreateObject);
    end else if (jData.FindPath('method').value = 'setObjectProperty') then
    begin
      Synchronize(@SetObjectProperty);
    end;
  end;
end;

procedure TMyThread.SetObjectProperty;
var  objId: Integer;
  propertyName: String;
  propertyValue: Variant;
  propInfo: PPropInfo;
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
      propertyName := jData.FindPath('params[1]').AsString;
      propertyValue := jData.FindPath('params[2]').Value;

      // Get the info about the property
      propInfo := GetPropInfo(objArray[objId], propertyName);

      // If the object has the property, change the value
      if Assigned(propInfo) then
      begin
        SetPropValue(objArray[objId], propertyName, jData.FindPath('params[2]').Value);
      end;
    end;
  end;
end;

end.
