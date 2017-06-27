<?php

/**
 * HTML template Class
 *  
 * @author Moysés Filipe Lopes Peixoto de Oliveira
 * @version 1.0
 * @access public
 * @modification 2016-10-20
 */

namespace Spell\UI\Layout;

use Spell\MVC\Route;
use Spell\Flash\Path;

class View extends AbstractView
{

    use Archive;

    /**
     *
     * @var \Spell\UI\Layout\Theme 
     */
    private $theme = null;

    /**
     * 
     * @param string $path
     * @param string $file
     * @param array $data
     */
    public function __construct($path, $file = null, $data = [])
    {
        $this->setPath($path);
        $this->setFile($file);
        $this->setData($data);
    }

    /**
     * 
     * @param \Spell\UI\Layout\Theme $theme
     */
    public function setTheme(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * 
     * @return \Spell\UI\Layout\Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * 
     * @return string
     */
    public function getFile()
    {
        if (!$this->file)
            $this->file = Route::getAction() . '.php';

        return $this->file;
    }

    /**
     * 
     * @param type $data
     * @param string $view
     */
    public function render()
    {
        return $this->fileRender(Path::combine([$this->getPath(), $this->getFile()]));
    }

}
