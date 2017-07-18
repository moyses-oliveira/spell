<?php

namespace Spell\UI\Layout;

use Spell\Flash\Path;
use \Spell\UI\Layout\Head;

/**
 * Description of Theme
 *
 * @author moyses-oliveira
 */
class Theme extends AbstractView
{

    use Archive;

    /**
     *
     * @var array
     */
    private $frame = [];

    /**
     *
     * @var array
     */
    private $views = [];

    /**
     *
     * @var \Spell\UI\Layout\Head 
     */
    private $head = null;

    /**
     * 
     */
    public function __construct()
    {
        $this->head = new Head();
    }

    /**
     * 
     * @param string $path
     */
    public function setPath($path)
    {
        $setting = Path::combine([$path, 'setting.php']);
        if(file_exists($setting))
            require $setting;
        
        $this->path = $path;
        return $this;
    }

    /**
     * 
     * @return \Spell\UI\Layout\Head 
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * 
     * @param array $meta
     */
    public function addMeta($meta)
    {
        $this->head->addMeta($meta);
        return $this;
    }

    /**
     * 
     * @param mixed $css
     */
    public function addCss($css)
    {
        $this->head->addCss($css);
        return $this;
    }

    /**
     * 
     * @param mixed $js
     */
    public function addJs($js)
    {
        $this->head->addJs($js);
        return $this;
    }

    /**
     * 
     * @param type $name
     * @param string $file
     */
    public function addFrame($name, $file)
    {
        $this->frame[$name] = $file;
        return $this;
    }

    /**
     * 
     * @return strings
     */
    public function getFrame($name)
    {
        return $this->frame[$name];
    }

    /**
     * 
     * @return string
     */
    public function renderFrame($name)
    {
        return $this->fileRender(Path::combine([$this->getPath(), $this->getFrame($name)]));
    }

    /**
     * 
     * @param type $name
     * @param \Spell\UI\Layout\View $view
     */
    public function addView($name, \Spell\UI\Layout\View $view) : Theme
    {
        $this->views[$name] = $view;
        return $this;
    }

    /**
     * 
     * @return \Spell\UI\Layout\View
     */
    public function getView($name)
    {
        return $this->views[$name];
    }

    /**
     * 
     * @return \Spell\UI\Layout\View
     */
    public function renderView($name)
    {
        return $this->getView($name)->render();
    }

    /**
     * Render theme with frames
     */
    public function render()
    {
        return $this->fileRender(Path::combine([$this->getPath(), $this->getFile()]));
    }

}
