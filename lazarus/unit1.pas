unit Unit1;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls, fpjson, jsonparser, lazlogger;

type

  { TForm1 }

  TForm1 = class(TForm)
    Button1: TButton;
    Edit1: TEdit;
    procedure Button1Click(Sender: TObject);
  private
    { private declarations }
  public
    { public declarations }
  end;

var
  Form1: TForm1;

implementation

{$R *.lfm}

{ TForm1 }

procedure TForm1.Button1Click(Sender: TObject);
var
  CRef : TPersistentClass;
  AControl : TButton;
begin
  CRef := GetClass('TComponent');
  if CRef <> nil then
  begin
     AControl := TButton.Create(Form1);
     with AControl do
     begin
        SetBounds(10,10,50,50);
        Caption:='Ok';
        Parent:=Form1;
     end;
     // AControl.Show;
  end;
  
  // AControl := TButton.Create(Form1);
  // AControl.SetBounds(10,10,200,30);
  // AControl.Caption:='Teste';
  // AControl.Parent:=Form1;
end;
// var button: TButton;
//   jData: TJSONData;
//   jObject: TJSONObject;
// begin
     // button:=TButton.Create(Form1);
     // button.SetBounds(10,10,200,30);
     // button.Caption:='Teste';
     // button.Parent:=Form1;

     // jData := GetJSON('{"method": "createObject", "params": [{"type": "TButton"}]}');
     // jObject := TJSONObject(jData);

     // if (jData.FindPath('params[0].type') <> Nil) then
     // Edit1.text := jData.FindPath('params[0].type').Value;
// end;

end.

