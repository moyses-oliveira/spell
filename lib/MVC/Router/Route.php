<?php

namespace Spell\MVC\Router;

class Route {

    const MODE_DEFAULT = 'Default';
    const MODE_REGEX = 'Regex';
    
    /**
     *
     * @var string 
     */
    private $expression = '';
    
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
     * @var string
     */
    private $mode = null;

    
    public function __construct(string $expression, string $namespace, string $theme, string $mode = 'DEFAULT')
    {
        $this->setExpression($expression);
        $this->setNamespace($namespace);
        $this->setTheme($theme);
        $this->setMode($mode);
    }
    
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
        $this->url = $url;
    }
    
    /**
     * 
     * @return string
     */
    public function getExpression() : string
    {
        return $this->expression;
    }

    /**
     * 
     * @param string $expression
     * @return $this
     */
    public function setExpression(string $expression)
    {
        $this->expression = $expression;
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
    }

    /**
     * 
     * @return type
     */
    public function getMode(): ?string
    {
        return $this->mode;
    }

    /**
     * 
     * @param string $mode
     * @return $this
     */
    public function setMode(string $mode)
    {
        $this->mode = $mode;
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
    }

    public function check($entry){var_dump($this->getMode());
        switch($this->getMode()):
            case static::MODE_DEFAULT;
                $this->setUrl($this->expression);
                return substr(strtolower($entry), 0, strlen($this->expression)) === $this->expression;
            case static::MODE_REGEX;
                $output = [];
                preg_match($this->expression, $entry, $output);
                $response = current($output);
                if(!$response)
                    return false;
                
                $this->setUrl($response);
                return !!$response; 
        endswitch;
    }
}
