<?php

/**
 * Base for tags class Helper Helper class
 *  
 * @author Moysés Filipe Lopes Peixoto de Oliveira
 * @version 1.0
 * @access public
 * @modification 2016-10-20
 */

namespace Spell\UI\HTML;

abstract class AbstractTag implements TagInterface {

    /**
     *
     * @var string 
     */
    protected $tag = '';

    /**
     *
     * @var array 
     */
    protected $attributes = [];

    /**
     *
     * @var array 
     */
    protected $class = [];

    /**
     *
     * @var array 
     */
    protected $childs = [];

    /**
     *
     * @var boolean 
     */
    protected $singleton = false;

    /**
     *
     * @var boolean 
     */
    protected $isInline = false;

    public function __construct($tag)
    {
        $singletons = ['meta', 'img', 'link', 'hr', 'br', 'embed', 'param', 'source', 'input'];
        $this->singleton = in_array($tag, $singletons);
        $this->tag = $tag;
    }

    /**
     * 
     * @return $this
     */
    public function inline()
    {
        $this->isInline = true;
        return $this;
    }

    /**
     * 
     * @param string $class
     * @return \Spell\UI\HTML\AbstractTag
     */
    public function setClass(string $class): AbstractTag
    {
        $classes = explode(' ', $class);
        return $this->setClasses($classes);
    }

    /**
     * 
     * @param array $classes
     * @return \Spell\UI\HTML\AbstractTag
     */
    public function setClasses(array $classes): AbstractTag
    {
        $this->class = [];
        foreach($classes as $class)
            $this->addClass($class);

        return $this->classToAttr();
    }

    /**
     * 
     * @param string $class
     * @return \Spell\UI\HTML\AbstractTag
     */
    public function addClass(string $class): AbstractTag
    {
        $break = explode(' ', $class);
        foreach($break as $cls)
            if(!empty($cls) && !in_array($cls, $this->class))
                $this->class[] = $cls;

        return $this->classToAttr();
    }

    /**
     * 
     * @param string $class
     * @return \Spell\UI\HTML\AbstractTag
     */
    public function rmClass(string $class): AbstractTag
    {
        if(($key = array_search($class, $this->class)) !== false)
            unset($this->class[$key]);

        return $this->classToAttr();
    }

    /**
     * 
     * @return \Spell\UI\HTML\AbstractTag
     */
    protected function classToAttr(): AbstractTag
    {
        $this->attributes['class'] = implode(' ', $this->class);
        return $this;
    }

    /**
     * 
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        foreach($attributes as $key => $value)
            $this->setAttr($key, $value);

        return $this;
    }

    /**
     * 
     * @param string $_key
     * @param string $value
     * @return $this
     */
    public function setAttr(string $_key, $value = true)
    {
        $key = strtolower($_key);

        if($key === 'class'):
            $value = $value === true ? '' : $value;
            return $this->setClass($value);
        endif;

        if($value === true)
            $value = $key;

        $this->attributes[strtolower($key)] = $value;
        return $this;
    }

    /**
     * 
     * @param string $_key
     * @return $this
     */
    public function removeAttr(string $_key)
    {
        $key = strtolower($_key);
        if(isset($this->attributes[$key]))
            unset($this->attributes[$key]);
        return $this;
    }

    /**
     * 
     * @param string $_key
     * @return string
     */
    public function getAttr(string $_key): string
    {
        $key = strtolower($_key);
        if(isset($this->attributes[$key]))
            return $this->attributes[$key];

        return '';
    }

    /**
     * 
     * @param string $_key
     * @return bool
     */
    public function hasAttr(string $_key): bool
    {
        $key = strtolower($_key);
        $keys = array_keys($this->attributes);
        return in_array($key, $keys);
    }

    /**
     * 
     * @param string $child
     * @return $this
     */
    public function setContent(string $child)
    {
        $this->appendChild($child);
        return $this;
    }

    /**
     * 
     * @param mixed $child
     * @return $this
     */
    public function appendChild($child)
    {
        if(!is_array($child)):
            $this->childs[] = $child;
        else:
            $merge = array_merge($this->childs, $child);
            $this->childs = array_values($merge);
        endif;
        return $this;
    }

    /**
     * 
     * @param mixed $child
     * @return $this
     */
    public function preppendChild($child)
    {
        if(!is_array($child)):
            $child = array_unshift($this->childs, $child);
        else:
            $merge = array_merge($child, $this->childs);
            $this->childs = array_values($merge);
        endif;
        return $this;
    }

    /**
     * 
     * @param int $index
     * @return $this
     */
    public function removeChild(int $index)
    {
        if(isset($this->childs[$index]))
            array_splice($this->childs, $index, 1);

        return $this;
    }

    public function removeChildByTag(string $tab)
    {
        $length = count($this->childs);
        for($i = 0; $i < $length; $i++)
            if($this->getChild($i)->getTag() === $tab)
                return $this->removeChild($i);

        return $this;
    }

    /**
     * 
     * @return $this
     */
    public function clearChilds()
    {
        $this->childs = [];
        return $this;
    }

    /**
     * 
     * @return $this
     */
    public function setChilds($childs)
    {
        $this->childs = [];
        foreach($childs as $child)
            $this->appendChild($child);

        return $this;
    }

    /**
     * 
     * @param int $index
     * @return \Spell\UI\HTML\AbstractTag
     */
    public function getChild(int $index)
    {
        return $this->childs[$index] ?? null;
    }

    /**
     * 
     * @param integer $level
     * @return string
     */
    public function renderChilds(int $level = 0): string
    {
        $content = '';
        foreach($this->childs as $child)
            if(is_array($child)):
                throw \Exception('Child can\'t be array.');
            elseif(is_object($child)):
                $content .= $this->renderChild($child, $level + 1);
            else:
                $content .= $child;
        endif;

        return $content;
    }

    /**
     * 
     * @param mixed $child
     * @param integer $level
     * @return string
     */
    protected function renderChild(RenderInterface $child, $level)
    {
        return $child->render($level + 1);
    }

    /**
     * 
     * @param int $level
     * @return string
     */
    public function render(int $level = 0): string
    {
        if($this->singleton)
            return $this->closed();

        if($this->tag === 'textarea')
            $this->isInline = true;

        $eol = !$this->isInline ? PHP_EOL : '';

        return $this->open(!$this->isInline) . $eol . $this->renderChilds($level) . $eol . $this->close();
    }

    /**
     * 
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * 
     * @param boolean $eol
     * @return string
     */
    public function open($eol = true)
    {
        $attributes = $this->renderAttributes();
        return "<$this->tag$attributes>" . ($eol ? PHP_EOL : '');
    }

    /**
     * 
     * @return string
     */
    public function close()
    {
        return "</$this->tag>" . PHP_EOL;
    }

    /**
     * 
     * @return string
     */
    public function closed()
    {
        $attributes = $this->renderAttributes();
        return "<$this->tag$attributes />" . PHP_EOL;
    }

    /**
     * 
     * 
     * @return string
     */
    public function renderAttributes()
    {
        if(!$this->attributes)
            return '';

        $cfg = array();
        foreach($this->attributes as $k => $v)
            $cfg[] = "$k=\"{$this->escapeAttr($v)}\"";

        return ' ' . implode(' ', $cfg);
    }
    
    /**
     * 
     * @param type $v
     * @return type
     */
    private function escapeAttr($v) {
        return htmlspecialchars($v, ENT_COMPAT);
    }

}
