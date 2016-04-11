<?php

namespace Gui\Components;

/**
 * This is the Window Class
 *
 * It is a visual component for window
 *
 * @author Rafael Reis @reisraff
 * @since 0.1
 */
class Window extends ContainerObject
{

    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TForm1';

    /**
     * Sets the window title
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->set('caption', $title);

        return $this;
    }

    /**
     * Gets the window title
     *
     * @return String
     */
    public function getTitle()
    {
        return $this->get('caption');
    }

    /**
     * Sets the icon
     *
     * @param string $icon
     *
     * @return self
     */
    public function setIcon($icon)
    {
        if (file_exists($icon) && preg_match('/ico$/i', $icon)) {
            $this->call(
                'icon.loadFromFile',
                [$icon]
            );
        }

        return $this;
    }

    /**
     * Sets the window state. Can be one of the following values: fullscreen, minimized, maximized, normal
     *
     * @param string $state
     *
     * @return self
     */
    public function setWindowState($state = 'normal')
    {
        $validStates = [
            'fullscreen',
            'minimized',
            'maximized',
            'normal'
        ];

        if (!in_array($state, $validStates)) {
            throw new \InvalidArgumentException('Unknown state: ' . $state);
        }

        $this->set('windowState', 'ws' . ucfirst($state));

        return $this;
    }
}
