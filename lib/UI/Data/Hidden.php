<?php

namespace Spell\UI\Data;

/**
 * Description of Input
 *
 * @author moysesoliveira
 */
class Hidden extends Field {

    /**
     * 
     * @param string $name
     * @param string|null $value
     * @param array $attr
     */
    public function __construct(string $name, ?string $value, array $attr = [])
    {
        $this->setName($name);
        $attr['type'] = 'hidden';
        $attributes = array_merge(compact('name'), $attr);
        $this->setField('input')->getField()->setAttributes($attributes);
        $this->setValue($value);
        $uid = base_convert(rand(0, pow(10, 10)), 10, 36);
        $nameid = str_replace(['[]', '[', ']'], [$uid, '-', '-'], $name);
        $this->setId(implode('-', ['hidden', $nameid]));
    }

}
