<?php

namespace Spell\UI\Layout;

/**
 * Description of ThemeCollection
 *
 * @author moysesoliveira
 */
class ThemeCollection {

    /**
     *
     * @var array 
     */
    protected $collection = [];

    /**
     * 
     * @param string $key
     * @return \Spell\UI\Layout\Theme
     */
    public function get(string $key) : Theme
    {
        return $this->collection[$key];
    }

    /**
     * 
     * @param string $key
     * @param string $path
     * @param string $file
     * @param string $headTitle
     * @param string $layout
     * @param string $title
     */
    public function add(string $key, string $path, string $file, string $headTitle)
    {
        $theme = new Theme();
        $theme->setPath($path);
        $theme->setFile($file);
        $theme->getHead()->setTitle($headTitle);
        $this->addTheme($key, $theme);
    }

    /**
     * 
     * @param string $key
     * @param \Spell\UI\Layout\Theme $theme
     */
    public function addTheme(string $key, Theme $theme)
    {
        $this->collection[$key] = $theme;
    }
}
