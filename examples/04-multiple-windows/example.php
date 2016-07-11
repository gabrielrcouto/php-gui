<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Label;
use Gui\Components\InputText;
use Gui\Components\Button;
use Gui\Components\Shape;
use Gui\Components\Window;
use Gui\Components\Checkbox;
use Gui\Components\Radio;
use Gui\Components\Select;
use Gui\Components\TextArea;
use Gui\Components\Item;

$application = new Application([
    'title' => 'My PHP Desktop Application',
    'left' => 30,
    'top' => 40,
    'width' => 480,
    'height' => 490
]);

$application->on('start', function() use ($application) {

    $label = new Label([
        'text' => 'First Form',
        'top' => 10,
        'left' => 40,
        'fontSize' => 20,
    ]);

    $shape = new Shape([
        'backgroundColor' => '#EEE',
        'borderColor' => '#DDD',
        'left' => 40,
        'top' => 60,
        'width' => 400,
        'height' => 380
    ]);

    $data = [
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'company' => 'Company'
    ];

    $c = 0;
    $form = [];
    foreach ($data as $key => $value) {
        $calculatedTop = ($c++ * 35);

        ${'label' . ucfirst($key)} = new Label([
            'text' => $value . ':',
            'top' => 72 + $calculatedTop,
            'left' => 45,
            'fontSize' => 10,
        ]);

        ${'inputText' . ucfirst($key)} = new InputText([
            'top' => 65 + $calculatedTop,
            'left' => 110,
            'fontSize' => 25,
            'width' => 320
        ]);

        $form[] = [
            'key' => $key,
            'label' => $value,
            'object' => ${'inputText' . ucfirst($key)}
        ];
    }

    $labelOfAge = new Label([
        'text' => '+18:',
        'top' => 208,
        'left' => 45,
        'fontSize' => 10,
    ]);

    $checkboxOfAge = new Checkbox([
        'top' => 205,
        'left' => 110
    ]);

    $form[] = [
        'key' => 'ofAge',
        'label' => '+18',
        'object' => $checkboxOfAge
    ];

    $labelState = new Label([
        'text' => 'State:',
        'top' => 238,
        'left' => 45,
        'fontSize' => 10,
    ]);

    $selectState = new Select([
        'top' => 235,
        'left' => 110,
        'width' => 320,
        'height' => 50
    ]);

    $states = [
        new Item('Acre (AC)', 0),
        new Item('Alagoas (AL)', 1),
        new Item('Amapá (AP)', 2),
        new Item('Amazonas (AM)', 3),
        new Item('Bahia (BA)', 4),
        new Item('Ceará (CE)', 5),
        new Item('Distrito Federal (DF)', 6),
        new Item('Espírito Santo (ES)', 7),
        new Item('Goiás (GO)', 8),
        new Item('Maranhão (MA)', 9),
        new Item('Mato Grosso (MT)', 10),
        new Item('Mato Grosso do Sul (MS)', 11),
        new Item('Minas Gerais (MG)', 12),
        new Item('Pará (PA) ', 13),
        new Item('Paraíba (PB)', 14),
        new Item('Paraná (PR)', 15),
        new Item('Pernambuco (PE)', 16),
        new Item('Piauí (PI)', 17),
        new Item('Rio de Janeiro (RJ)', 18),
        new Item('Rio Grande do Norte (RN)', 19),
        new Item('Rio Grande do Sul (RS)', 20),
        new Item('Rondônia (RO)', 21),
        new Item('Roraima (RR)', 22),
        new Item('Santa Catarina (SC)', 23),
        new Item('São Paulo (SP)', 24),
        new Item('Sergipe (SE)', 25),
        new Item('Tocantins (TO)', 26),
    ];
    $selectState->setItems($states);
    $selectState->setReadOnly(true);

    $form[] = [
        'key' => 'state',
        'label' => 'State',
        'object' => $selectState
    ];

    $labelGender = new Label([
        'text' => 'Gender:',
        'top' => 278,
        'left' => 45,
        'fontSize' => 10,
    ]);

    $checkboxGender = new Radio([
        'top' => 275,
        'left' => 110,
        'height' => 50
    ]);

    $items = [
        new Item('Male', 0),
        new Item('Female', 1),
    ];
    $checkboxGender->setItems($items);

    $form[] = [
        'key' => 'gender',
        'label' => 'Gender',
        'object' => $checkboxGender
    ];

    $textArea = new TextArea([
        'value' => 'Obs',
        'top' => 340,
        'left' => 50,
        'width' => 380,
        'height' => 90
    ]);

    $form[] = [
        'key' => 'obs',
        'label' => 'Obs',
        'object' => $textArea
    ];

    $button = new Button([
        'value' => 'Save',
        'top' => 450,
        'left' => 40,
        'width' => 400
    ]);

    $button->on('click', function () use ($form, $items, $states) {
        $window = new Window([
            'title' => 'Form1 Info',
            'width' => 400,
            'height' => 400,
        ]);

        $c = 0;
        foreach ($form as $value) {
            $calculatedTop = ($c++ * 35);

            ${'label' . ucfirst($value['key'])} = new Label(
                [
                    'text' => $value['label'] . ':',
                    'top' => 10 + $calculatedTop,
                    'left' => 30,
                    'fontSize' => 10,
                ],
                $window
            );

            $objValue = null;

            if ($value['object'] instanceof InputText || $value['object'] instanceof TextArea) {
                $objValue = $value['object']->getValue();
            } elseif ($value['object'] instanceof Checkbox) {
                $objValue = $value['object']->getChecked() ? 'Yes' : 'No';
            } elseif ($value['object'] instanceof Radio) {
                $objValue = $items[$value['object']->getChecked()]->getLabel();
            } elseif ($value['object'] instanceof Select) {
                $objValue = $states[$value['object']->getChecked()]->getLabel();
            }

            ${$value['key']} = new Label(
                [
                    'text' => $objValue,
                    'top' => 10 + $calculatedTop,
                    'left' => 100,
                    'fontSize' => 10,
                ],
                $window
            );
        }
    });
});

$application->run();
