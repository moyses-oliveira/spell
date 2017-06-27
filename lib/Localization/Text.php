<?php

namespace Spell\Localization;

/**
 * Description of Text
 *
 * @author moysesoliveira
 */
class Text {
    
    public $collection = [];
    
    public function set(string $key, string $value) : Text
    {
        $this->collection[$key] = $value;
        return $this;
    }
    
    public function get(string $key): string {
        return $this->collection[$key] ?? $key;
    }
    
    public function load(array $collection) {
        foreach($collection as $k=>$v)
            $this->collection[$k] = $v;
    }
}
