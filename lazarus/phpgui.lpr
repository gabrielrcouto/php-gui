program phpgui;

{$mode objfpc}{$H+}

uses
  {$IFDEF UNIX}{$IFDEF UseCThreads}
  cthreads,
  {$ENDIF}{$ENDIF}
  Interfaces, // this includes the LCL widgetset
  Forms, unit1, unitipcthread
  { you can add units after this };

{$R *.res}

var
    IpcThread : TIpcThread;

begin
  IpcThread := TIpcThread.Create(False);

  RequireDerivedFormResource:=True;
  Application.Initialize;
  Application.CreateForm(TForm1, Form1);
  Application.Run;
  Application.BringToFront();
end.

