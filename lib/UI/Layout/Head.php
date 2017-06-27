<?php

/**
 * HTML header Class
 *  
 * @author Moysés Filipe Lopes Peixoto de Oliveira
 * @version 1.0
 * @access public
 * @modification 2016-10-20
 */

namespace Spell\UI\Layout;

use Spell\MVC\Flash\Route;
use Spell\UI\HTML\Tag;
use Spell\UI\JQuery\UIV;

class Head {

    /**
     *
     * @var array
     */
    private $meta = [];

    /**
     *
     * @var array
     */
    private $css = [];

    /**
     *
     * @var array
     */
    private $js = [];

    /**
     *
     * @var array
     */
    private $title = [];

    /**
     *
     * @var string
     */
    private $title_separator = ' | ';

    /**
     *
     * @var \Spell\UI\JQuery\UIV
     */
    private $uiv = null;

    /**
     * 
     */
    public function __construct()
    {
        $this->uiv = new UIV();
    }

    /**
     * 
     * @return UIV
     */
    public function getUIV(): UIV
    {
        return $this->uiv;
    }

    public function addMeta($meta)
    {
        if(!is_array($meta))
            return;
        if(isset($meta[0]))
            $this->meta = array_merge($this->meta, $meta);
        else
            $this->meta[] = $meta;
    }

    public function clearMeta()
    {
        $this->meta = [];
    }

    public function addCss($css)
    {
        if(!is_array($css)):
            $this->css[] = ['href' => $css, 'media' => 'all'];
            return;
        endif;

        if(isset($css['href'])):
            if(!isset($css['media']))
                $css['media'] = 'all';

            $this->css[] = $css;
            return;
        endif;

        foreach($css as $style):
            $this->addCss($style);
        endforeach;
    }

    public function clearCss()
    {
        $this->css = [];
    }

    public function addJs($js)
    {
        if(!is_array($js)):
            $this->js[] = ['src' => $js];
            return;
        endif;

        if(isset($js['src'])):
            $this->js[] = $js;
            return;
        endif;
        foreach($js as $script):
            $this->addJs($script);
        endforeach;
    }

    public function clearJs()
    {
        $this->js = [];
    }

    public function addTitle($title)
    {
        array_unshift($this->title, $title);
    }

    public function setTitle()
    {
        $this->title = func_get_args();
    }

    public function getTitle(): array
    {
        return $this->title;
    }

    public function setTitleSeparator($title_separator)
    {
        $this->title_separator = $title_separator;
    }

    public function render()
    {
        $head = Tag::mk('head');

        $content = implode($this->title_separator, $this->title);
        $head->appendChild(Tag::mk('title', false, true)->setContent(trim($content, $this->title_separator . ' ')));

        foreach($this->meta as $attr)
            $head->appendChild(Tag::mk('meta')->setAttributes($attr));

        foreach($this->css as $attr)
            $head->appendChild($this->getStyle($attr));

        foreach($this->js as $attr)
            $head->appendChild($this->getScript($attr));

        $uiv = json_encode((object) $this->getUIV()->get(), JSON_PRETTY_PRINT);
        $uivScript = Tag::mk('script')->setAttr('type', 'application/json')->setAttr('property', 'uiv')->setContent($uiv);
        $head->appendChild($uivScript);
        return $head->render();
    }

    public function getStyle($attr)
    {
        if(!$this->isUrl($attr['href']))
            $attr['href'] = Route::trace($attr['href']);

        $style = Tag::mk('link')->setAttr('type', 'text/css')->setAttr('rel', 'stylesheet');
        return $style->setAttributes($attr);
    }

    public function getScript($attr)
    {
        if(!$this->isUrl($attr['src']))
            $attr['src'] = Route::trace($attr['src']);

        return Tag::mk('script', false, true)->setAttr('type', 'text/javascript')->setAttributes($attr);
    }

    public function isUrl($url)
    {
        return substr($url, 0, 2) == '//' || filter_var($url, FILTER_VALIDATE_URL);
    }

}
