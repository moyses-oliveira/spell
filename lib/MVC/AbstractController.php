<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Spell\MVC;

use Spell\Flash\DBAL;
use Doctrine\ORM\EntityManager;
use Spell\UI\JQuery\UIV;
use Spell\MVC\Flash\Route;

/**
 * Controller base to MVC application
 *
 * @author moysesoliveira
 */
abstract class AbstractController {

    /**
     *
     * @var \Spell\UI\Layout\Theme 
     */
    protected $theme = null;

    /**
     * 
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * 
     * @return \Spell\Server\URL
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 
     * @return \Spell\UI\Layout\Theme
     */
    public function getTheme(): \Spell\UI\Layout\Theme
    {
        return $this->theme;
    }

    /**
     * 
     * @param \Spell\UI\Layout\Theme $theme
     * @return 
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        $uiv = $this->getUIV();
        $route = [
            'index' => Route::getIndex(),
            'module' => Route::getModule(),
            'action' => Route::getAction(),
            'root' => Route::getRoot(),
            'site' => Route::getSite(),
            'urs' => Route::getUrs()
        ];
        $uiv->add('mvc', compact('route'));
        return $this;
    }

    /**
     * 
     * @return \Spell\DB
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * 
     * @param type $data
     */
    protected function render($data = [], $code = 200)
    {
        $theme = $this->getTheme();
        $theme->getView('content')->setData($data);
        echo $theme->setData($data)->header($code)->render();
    }

    /**
     *
     */
    protected function getUIV(): UIV
    {
        return $this->getTheme()->getHead()->getUIV();
    }

    /**
     * 
     * @param type $data
     */
    protected function json($data = [], $code = 200)
    {
        $json = new \Spell\UI\Layout\Json();
        echo $json->setData($data)->header($code)->render();
    }

    /**
     * 
     * @param array $error
     */
    protected function json404(array $error = ['Page can\'t be found.'])
    {
        $json = new \Spell\UI\Layout\Json();
        echo $json->setData(['success' => false, 'error' => $error])->header(404)->render();
    }

    /**
     * 
     * @param array $error
     */
    protected function json403(array $error = ['Forbiten.'])
    {
        $json = new \Spell\UI\Layout\Json();
        echo $json->setData(['success' => false, 'error' => $error])->header(403)->render();
    }

    /**
     * 
     * @param array $error
     */
    protected function json400(array $error = ['Invalid entry.'])
    {
        $json = new \Spell\UI\Layout\Json();
        echo $json->setData(['success' => false, 'error' => $error])->header(400)->render();
    }

    /**
     * 
     * @return \Spell\UI\Layout\View
     */
    protected function getView()
    {
        return $this->getTheme()->getView('content');
    }

    /**
     * 
     * @param string $alias
     * @return EntityManager
     */
    protected function getEm(string $alias = 'default'): EntityManager
    {
        return DBAL::get($alias)->getEm();
    }

}
