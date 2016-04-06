<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/Rss.php';

use Example\Rss;
use Gui\Application;
use Gui\Components\Button;
use Gui\Components\Div;
use Gui\Components\Label;
use Gui\Components\Shape;
use Gui\Components\Window;

$application = new Application([
    'backgroundColor' => '#181818',
    'height' => 740,
    'left' => 248,
    'title' => 'php.internals reader',
    'top' => 50,
    'width' => 860,
]);

$application->on('start', function() use ($application) {
    $title = new Label([
        'backgroundColor' => '#181818',
        'fontColor' => '#FFFFFF',
        'fontFamily' => 'Gill Sans',
        'fontSize' => 30,
        'left' => 25,
        'text' => 'News',
        'top' => 25,
    ]);

    $loading = new Label([
        'fontColor' => '#a0a0a0',
        'fontFamily' => 'Gill Sans',
        'fontSize' => 20,
        'left' => 25,
        'text' => 'Loading messages...',
        'top' => 80,
    ]);

    $application->loop->addTimer(1, function() use ($application, $loading) {
        $messages = Rss::getLastest();
        $postWindow = null;

        $loading->setVisible(false);

        $subjectTitle = new Label([
            'fontColor' => '#a0a0a0',
            'fontFamily' => 'Lucida Sans Unicode',
            'fontSize' => 13,
            'left' => 25,
            'text' => 'TITLE',
            'top' => 80,
            'width' => 600,
        ]);

        $authorTitle = new Label([
            'fontColor' => '#a0a0a0',
            'fontFamily' => 'Lucida Sans Unicode',
            'fontSize' => 13,
            'left' => 600,
            'text' => 'AUTHOR',
            'top' => 80,
            'width' => 260,
        ]);

        $titleLine = new Shape([
            'backgroundColor' => '#a0a0a0',
            'borderColor' => '#a0a0a0',
            'height' => 1,
            'left' => 25,
            'top' => 100,
            'width' => 810
        ]);

        for ($i = 0; $i < count($messages['titles']); $i++) {
            $link = $messages['links'][$i];
            $title = $messages['titles'][$i];

            $backgroundShape = new Shape([
                'backgroundColor' => '#181818',
                'borderColor' => '#181818',
                'height' => 30,
                'left' => 25,
                'top' => 115 + ($i * 30),
                'width' => 810,
            ]);

            $title = new Label([
                'autoSize' => false,
                'fontColor' => '#fcfcfc',
                'fontFamily' => 'Lucida Sans Unicode',
                'fontSize' => 13,
                'height' => 20,
                'left' => 25,
                'text' => $title,
                'top' => 120 + ($i * 30),
                'width' => 550,
            ]);

            $author = new Label([
                'autoSize' => false,
                'fontColor' => '#fcfcfc',
                'fontFamily' => 'Lucida Sans Unicode',
                'fontSize' => 13,
                'height' => 20,
                'left' => 600,
                'text' => $messages['authors'][$i],
                'top' => 120 + ($i * 30),
                'width' => 260,
            ]);

            $clickFunction = function() use ($link, $title) {
                $content = Rss::getSingle($link);

                $postWindow = new Window([
                    'height' => 740,
                    'width' => 860,
                ]);

                $div = new Div([
                    'height' => 740,
                    'width' => 860,
                ], $postWindow);

                $content = new Label([
                    'autoSize' => true,
                    'text' => $content,
                ], $div);
            };

            $mouseEnterFunction = function() use ($backgroundShape) {
                $backgroundShape->setBackgroundColor('#282828');
            };

            $mouseLeaveFunction = function() use ($backgroundShape) {
                $backgroundShape->setBackgroundColor('#181818');
            };

            $backgroundShape->on('mouseEnter', $mouseEnterFunction);
            $title->on('mouseEnter', $mouseEnterFunction);

            $backgroundShape->on('mouseLeave', $mouseLeaveFunction);
            $title->on('mouseLeave', $mouseLeaveFunction);

            $backgroundShape->on('mouseDown', $clickFunction);
            $title->on('mouseDown', $clickFunction);
        }
    });
});

$application->run();
