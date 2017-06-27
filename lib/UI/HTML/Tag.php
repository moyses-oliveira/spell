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

class Tag extends AbstractTag {

    /**
     * 
     * @param string $element
     * @param string|null $class
     * @param string|null $inline
     * @return \Spell\UI\HTML\Tag
     */
    public static function mk(string $element, ?string $class = null, ?string $inline = null): Tag
    {

        $tag = new Tag($element);

        if($class)
            $tag->addClass($class);

        if($inline)
            $tag->inline();

        return $tag;
    }

    /**
     * 
     * @param string $href
     * @param string|null $class
     * @param string|null $target
     * @return \Spell\UI\HTML\Tag
     */
    public static function a(string $href, ?string $class = null, ?string $target = null): Tag
    {
        $a = static::mk('a', $class);
        $a->setAttr('href', $href);

        if($target)
            $a->setAttr('target', $target);

        return $a;
    }

    /**
     * 
     * @param string|null $class
     * @param string|null $id
     * @return \Spell\UI\HTML\Tag
     */
    public static function div(?string $class = null, ?string $id = null): Tag
    {
        $div = static::mk('div', $class);
        if($id)
            $div->setAttr('id', $id);

        return $div;
    }

}
