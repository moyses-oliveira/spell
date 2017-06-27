<?php

namespace Spell\Flash;

/**
 * Description of Html
 *
 * @author moysesoliveira
 */
class Html
{
    public static function make($tree){
        if(is_string($tree))
            return $tree;
        
        if(static::isAssoc($tree)):
            $tag = isset($tree['<']) ? $tree['<'] : 'div';
            $attributes = isset($tree['?']) ? $tree['?'] : [];
            $content = isset($tree['>']) ? static::make($tree['>']) : '';
            return static::tag($tag, $attributes, $content);
        endif;
        foreach($tree as $t)
            static::make($t);
    }
    
    public static function tag($tag, $attributes = [], $content = null){
        $attr = static::buildAttributes($attributes);
        $element = "<$tag$attr";
        if($content === false)
            return $element . '/>';
        
        return "$element>$content</$tag>";
    }
    
    /**
     * Check if is an associative array 
     *
     * @param array $array
     * @return bool
     */
	private static function isAssoc(array $array)
	{
		$keys = array_keys($array);
		// If the array keys of the keys match the keys
		return array_keys($keys) !== $keys;
	}
	/**
     * 
     * @param type $attr
     * @return string
     */
    protected static function buildAttributes($attr)
    {	
        if(!$attr)
            return '';
        
        if(!static::isAssoc($attr))
            throw new Exception('Attributes must be key=>value associative array.');
		
		unset($attr['elm']);
		if(isset($attr['childnodes']))
			unset($attr['childnodes']);
		
		if(!$attr)
			return '';
			
        $cfg = array();
        foreach ($attr as $k => $v)
            $cfg[] = $k . '="' . str_replace('"', '&quot;', $v) . '"';

        return ' ' . implode(' ', $cfg);
    }
}
