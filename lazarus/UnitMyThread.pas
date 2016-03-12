unit UnitMyThread;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls, Pipes, fpjson, jsonparser, unit1;

type
  TMyThread = class(TThread)
  private
    procedure CreateObject;
  protected
    procedure Execute; override;
    procedure Output(Text: String);
  public
  end;

var
   F: Text;
   jData: TJSONData;

implementation

procedure TMyThread.CreateObject;
var obj: TControl;
  objClass: TPersistentClass;
begin
  if (jData.FindPath('params[0].lazarusClass') <> Nil) then
  begin
    objClass := GetClass(jData.FindPath('params[0].lazarusClass').value);

    if objClass <> Nil then
    begin
      if objClass.InheritsFrom(TControl) then
      begin
        obj := TControl(TControlClass(objClass).Create(Form1));
        obj.Parent := Form1;
        // obj.Caption := 'Ok';
        // obj.SetBounds(10,10,200,30);
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
  // jObject: TJSONObject;
  AStream: TInputPipeStream;
  AString: string;
begin
  // Register all the classes
  RegisterClass(TButton);

  AStream := TInputPipeStream.Create(StdInputHandle);

  // Initializes de stdout
  Assign(F, '');
  Rewrite(F);

  while True do
  begin
    if AStream.NumBytesAvailable > 0 then
    begin
      SetLength(AString, AStream.NumBytesAvailable);
      AStream.ReadBuffer(AString[1], Length(AString));

      jData := GetJSON(AString);
      // jObject := TJSONObject(jData);
      // Output('Got: ' + jObject.Get('method'));

      if (jData.FindPath('method') <> Nil) then
      begin
        Output('Got: ' + jData.FindPath('method').value);

        if (jData.FindPath('method').value = 'createObject') then
        begin
          Synchronize(@CreateObject);
        end;
      end;
    end
    else
    begin
      Sleep(10);
    end;
  end;
end;

end.
