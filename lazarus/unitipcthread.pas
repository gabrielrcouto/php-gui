unit UnitIpcThread;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls, Pipes,
  fpjson, jsonparser, unit1, typinfo, ExtCtrls, Variants, ComCtrls, EditBtn, LMessages,
  LCLIntf;

const
  LM_GUI_MESSAGE = LM_USER + 1;

type

  { TIpcThread }

  TIpcThread = class(TThread)
  private
  protected
    procedure Execute; override;
    procedure ProcessMessages();
  public
  end;

var
  B: String;
  // The cumulative Stdin string buffer
  StdinStringBuffer: String;

implementation

procedure TIpcThread.Execute;
var
  // The Stdin Pipe
  StdinStream: TInputPipeStream;
  // The string returned from stdin
  StdinString: String;
  BytesAvailable: Integer;
begin
  // Initializes the input pipe (Stdin)
  StdinStream := TInputPipeStream.Create(StdInputHandle);
  // The buffer starts empty
  StdinStringBuffer := '';

  while (Form1 = Nil) or (Application.IsWaiting) do
  begin
    // Waiting Form1 be <> Nil
    Sleep(1);
  end;

  Sleep(1000);

  SetLength(StdinString, 1);

  while True do
  begin
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

    // 60fps = one frame after 16ms
    if StdinStringBuffer <> '' then
    begin
      ProcessMessages();
    end;
  end;
end;

procedure TIpcThread.ProcessMessages();
var
  CurrentPos: Integer;
  Message: String;
begin
  CurrentPos := Pos(#0, StdinStringBuffer);

  while CurrentPos > 0 do
  begin
    Message := Copy(StdinStringBuffer, 1, CurrentPos);

    // Send message to the GUI thread
    SendMessage(Form1.Handle, LM_GUI_MESSAGE, Integer(Message), 0);

    // Remove the message from the buffer
    Delete(StdinStringBuffer, 1, CurrentPos);

    Break;
  end;
end;

end.
