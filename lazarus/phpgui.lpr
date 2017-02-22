program phpgui;

{$mode objfpc}{$H+}
{$WARNINGS OFF}

uses
  {$IFDEF UNIX}{$IFDEF UseCThreads}
  cthreads,
  {$ENDIF}{$ENDIF}
  Classes,
  Interfaces, // this includes the LCL widgetset
  Forms, unit1, unitipcthread
  { you can add units after this };

{$R *.res}

var
    IpcThread : TIpcThread;

begin
  IpcThread := TIpcThread.Create(False);
  // IpcThread.Priority := tpLowest;

  RequireDerivedFormResource:=True;
  Application.Initialize;
  Application.CreateForm(TForm1, Form1);

  // Application.OnException := @Form1.ApplicationExceptionHandler;

  Application.Run;
  Application.BringToFront();
end.

