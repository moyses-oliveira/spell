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
