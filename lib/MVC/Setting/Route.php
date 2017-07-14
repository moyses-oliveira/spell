<?php

namespace Spell\MVC\Setting;

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
     * @var string
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
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme;
    }

    /**
     * 
     * @param string $theme
     * @return $this
     */
    public function setTheme(string $theme)
    {
        $this->theme = $theme;
        return $this;
    }

    public static function init()
    {
        return new self();
    }

}
