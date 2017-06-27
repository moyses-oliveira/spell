<?php

namespace Spell\MVC\Setting;

use Spell\UI\Layout\Theme;

class Route {

    /**
     *
     * @var string 
     */
    private $url = '';

    /**
     *
     * @var string 
     */
    private $namespace = '';

    /**
     *
     * @var Theme
     */
    private $theme = '';

    /**
     * 
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * 
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->url = strtolower(trim($url, '/'));
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * 
     * @param string $namespace
     * @return $this
     */
    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * 
     * @return Theme
     */
    public function getTheme(): Theme
    {
        return $this->theme;
    }

    /**
     * 
     * @param Theme $theme
     * @return $this
     */
    public function setTheme(Theme $theme)
    {
        $this->theme = $theme;
        return $this;
    }

    public static function init()
    {
        return new self();
    }

}
