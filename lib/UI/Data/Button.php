<?php

namespace Spell\UI\Data;

/**
 * Description of Input
 *
 * @author moysesoliveira
 */
class Button extends Field {

    /**
     * 
     * @param string $name
     * @param string $type
     * @param string $content
     * @param string $value
     */
    public function __construct(string $name, string $type, string $content, string $value, array $attr = []) {
        $this->setName($name);
        $attributes = array_merge(compact('name', 'value', 'type'), $attr);
        $this->setField('button')->getField()->setAttributes($attributes)->setContent($content);
        $uid = $this->uid();
        $nameid = str_replace(['[]', '[', ']'], [$uid, '-', '-'], $name);
        $this->setId(implode('-', ['button', $type, $nameid]));
    }

    /**
     * 
     * @param string $value
     */
    public function setValue(?string $value) : FieldInterface {
        $this->getField()->setAttr('value', $value);
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getValue(): string {
        return $this->getField()->getAttr('value');
    }

}
