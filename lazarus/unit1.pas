unit Unit1;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls, Pipes,
  fpjson, jsonparser, typinfo, ExtCtrls, Variants, ComCtrls, EditBtn, LMessages,
  LCLIntf;

const
  LM_GUI_MESSAGE = LM_USER + 1;

type

  { TForm1 }

  TForm1 = class(TForm)
    procedure FormCreate(Sender: TObject);
  private
    procedure CallObjectMethod;
    procedure CreateObject;
    procedure DestroyObject;
    procedure GetObjectProperty;
    procedure GuiMessageHandler(var Msg: TLMessage); message LM_GUI_MESSAGE;
    procedure Ping;
    procedure SetObjectEventListener;
    procedure SetObjectProperty;
    procedure DisplayMessage;
  protected
    procedure Output(Msg: String);
    procedure ParseMessage(Msg: String);
  public
    messages: array of String;
  end;

type
  TEventHandler = class(TObject)
  private
  protected
  public
    EventName: String;
    ObjectId: Integer;
    procedure Call(Sender: TObject);
    procedure Output(Msg: String);
  end;

var
  Form1: TForm1;
  jData: TJSONData;
  objArray: array of TControl;

implementation

{$R *.lfm}

{ TForm1 }

procedure TForm1.FormCreate(Sender: TObject);
begin
  // Register all the classes
  // @TODO - Move it from here!
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
  RegisterClass(TProgressBar);
  RegisterClass(TDirectoryEdit);
  RegisterClass(TFileNameEdit);

  SetLength(objArray, 1);
  objArray[0] := self;
end;

procedure TForm1.CallObjectMethod;
var
  messageId: Integer;
  messageMethodName: String;
  objId: Integer;
  intCtrl: array of Integer;
  strCtrl: array of String;
  sent: Boolean;
  counter: Integer;
  max: Integer;
  x: Integer;
  y: Integer;
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
    else if messageMethodName = 'picture.bitmap.canvas.putImageData' then
    begin
      counter := 0;
      max := (jData.FindPath('params[2]') as TJSONArray).Count;

      for x := 0 to (objArray[objId] as TImage).Picture.Bitmap.Width - 1 do
      begin
        for y := 0 to (objArray[objId] as TImage).Picture.Bitmap.Height - 1 do
        begin
          if counter < max then
          begin
            (objArray[objId] as TImage).Picture.Bitmap.Canvas.Pixels[x, y] := (jData.FindPath('params[2]') as TJSONArray).Integers[counter];
          end;

          Inc(counter);
        end;
      end;
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

procedure TForm1.CreateObject;
var obj: TControl;
  objClass: TPersistentClass;
  objIndex: Integer;
  objParent: Integer;
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
          objParent := jData.FindPath('params[0].parent').AsInteger;

          obj := TControl(TControlClass(objClass).Create(objArray[objParent]));
          obj.Parent := TWinControl(objArray[objParent]);
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

procedure TForm1.DestroyObject;
var obj: TControl;
  objId: Integer;
  messageId: Integer;
begin
  // param[0] = objectId
  // check if objectId is valid
  if (jData.FindPath('params[0]') <> Nil) AND (jData.FindPath('params[0]').AsInteger < Length(objArray)) then
  begin
    objId := jData.FindPath('params[0]').AsInteger;
    obj := objArray[objId];

    FreeAndNil(obj);

    messageId := jData.FindPath('id').AsInteger;
    Output('{"id": ' + IntToStr(messageId) + ', "result": ' + IntToStr(objId) + '}');
  end;
end;

procedure TForm1.GetObjectProperty;
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

      if (objArray[objId].ClassType.InheritsFrom(TFileNameEdit)) AND (propertyName = 'DialogFiles') then
      begin
        // Get file list from TFileNameEdit
        return := (objArray[objId] as TFileNameEdit).DialogFiles.Text;
        return := StringReplace(return, '\', '\\', [rfReplaceAll]);
        return := StringReplace(return, #13#10, ';', [rfReplaceAll]);


        messageId := jData.FindPath('id').AsInteger;
        Output('{"id": ' + IntToStr(messageId) + ',"result": "' + return + '"}');
      end
      else
      begin
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
          return := StringReplace(return, '\', '\\', [rfReplaceAll]);
          return := StringReplace(return, '"', '\"', [rfReplaceAll]);
          Output('{"id": ' + IntToStr(messageId) + ',"result": ' + return + '}');
        end;
      end;
    end;
  end;
end;

procedure TForm1.GuiMessageHandler(var Msg: TLMessage);
begin
  ParseMessage(String(Msg.wParam));
end;

procedure TForm1.Output(Msg: String);
begin
  Write(StdOut, Msg + #0);
  Flush(StdOut);
end;

procedure TForm1.ParseMessage(Msg: String);
begin
  jData := GetJSON(Msg);


  // All messages need a method
  if (jData.FindPath('method') <> Nil) then
  begin
    // Find the corret function for the method
    // Because we will modify the GUI, we need to Synchronize this thread with the GUI thread
    if (jData.FindPath('method').value = 'createObject') then
    begin
      CreateObject;
    end else if (jData.FindPath('method').value = 'destroyObject') then
    begin
      DestroyObject;
    end else if (jData.FindPath('method').value = 'setObjectEventListener') then
    begin
      SetObjectEventListener;
    end else if (jData.FindPath('method').value = 'setObjectProperty') then
    begin
      SetObjectProperty;
    end else if (jData.FindPath('method').value = 'getObjectProperty') then
    begin
      GetObjectProperty;
    end else if (jData.FindPath('method').value = 'callObjectMethod') then
    begin
      CallObjectMethod;
    end else if (jData.FindPath('method').value = 'showMessage') then
    begin
      DisplayMessage;
    end else if (jData.FindPath('method').value = 'ping') then
    begin
      Ping;
    end else if (jData.FindPath('method').value = 'exit') then
    begin
      halt;
    end;
  end;
end;

procedure TForm1.Ping;
var
  messageId: Integer;
  microtime: String;
begin
  messageId := jData.FindPath('id').AsInteger;
  microtime := jData.FindPath('params[0]').AsString;

  Output('{"id": ' + IntToStr(messageId) + ', "result": "' + microtime + '"}');
end;

procedure TForm1.SetObjectEventListener;
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

procedure TForm1.DisplayMessage;
var
  Title,
  Message : string;
begin
  if (jData.FindPath('params[1]') <> Nil) AND (jData.FindPath('params[1]').AsString <> '') then
  begin
    Title := jData.FindPath('params[1]').AsString;
  end
  else
  begin
    Title := Application.MainForm.Caption;
  end;
  Message := StringReplace(jData.FindPath('params[0]').AsString, '\n', sLineBreak, [rfReplaceAll] );
  Application.MessageBox( @Message[1], @Title[1] );
end;

procedure TForm1.SetObjectProperty;
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
        if PropIsType(obj, propertyName, tkInteger) then
        begin
          SetOrdProp(obj, propertyName, jData.FindPath('params[2]').AsInteger);
        end
        else if (PropIsType(obj, propertyName, tkString)) or 
          (PropIsType(obj, propertyName, tkAString)) or 
          (PropIsType(obj, propertyName, tkLString)) or 
          (PropIsType(obj, propertyName, tkSString)) or 
          (PropIsType(obj, propertyName, tkUString)) or 
          (PropIsType(obj, propertyName, tkWString)) then
        begin
          SetStrProp(obj, propertyName, jData.FindPath('params[2]').AsString);
          Flush(StdOut);
        end
        else
        begin
          // @TODO: Convert propertyValue to a object checking with PropIsType and GetObjectPropClass
          // SetPropValue(obj, propertyName, propertyValue);
        end;
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

procedure TEventHandler.Output(Msg: String);
begin
  Write(StdOut, Msg + #0);
  Flush(StdOut);
end;

end.
