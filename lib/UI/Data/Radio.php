<?php

namespace Spell\UI\Data;

use Spell\UI\HTML\Tag;

/**
 * Description of Input
 *
 * @author moysesoliveira
 */
class Radio extends Field {

    /**
     * 
     * @param string $name
     * @param string $value
     * @param string $label
     * @param bool $checked
     */
    public function __construct(string $name, string $value, string $label, bool $checked = false)
    {
        $type = 'radio';
        $this->setBox(Tag::mk('div'));

        $this->setName($name);
        $this->setLabel($label);
        $this->setField('input')->getField()->setAttributes(compact('name', 'value', 'type'));
        if($checked)
            $this->getField()->setAttr('checked');

        $uid = base_convert(rand(0, pow(10, 10)), 10, 36);
        $mark = base_convert(rand(0, pow(10, 10)), 10, 36);
        $nameid = str_replace(['[]', '[', ']'], [$uid, '-', '-'], $name) . $mark;
        $this->getField()->setAttr('id', $nameid);
        $this->getLabel()->setAttr('for', $nameid);
        $this->getBox()->preppendChild($this->getField());
    }

    /**
     * Render box, div and field element
     * 
     * @return string
     */
    public function render(): string
    {
        return $this->getBox()->render();
    }

}
