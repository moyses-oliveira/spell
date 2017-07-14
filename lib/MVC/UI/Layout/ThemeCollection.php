<?php

namespace Spell\MVC\UI\Layout;

use Spell\Flash\Path;
use Spell\MVC\Flash\App;
use Spell\MVC\Flash\Route;
use Spell\UI\Layout\Theme;
use Spell\UI\Layout\View;

/**
 * 
 *
 * @author moysesoliveira
 */
class ThemeCollection extends \Spell\UI\Layout\ThemeCollection {
  
    /**
     * 
     * @param string $key
     * @return \Spell\UI\Layout\Theme
     */
    public function get(string $key) : Theme
    {
        $theme = $this->collection[$key];
        $viewPath = Path::combine([Route::getPath(), App::getPath(), 'View', Route::getController()]);
        $viewFile = Route::getAction() . '.php';
        $theme->addView('content', new View($viewPath, $viewFile));
        return $theme;
    }
}
