<?php

namespace Spell\UI\Data;

use Spell\UI\HTML\Tag;

/**
 * Description of Input
 *
 * @author moysesoliveira
 */
class Textarea extends Field {

    /**
     * 
     * @param string $name
     * @param int $length
     * @param type $label
     * @param type $value
     * @param array $attr
     */
    public function __construct(string $name, int $length, $label = null, $value = null, array $attr = [])
    {
        $this->setName($name);
        $attributes = array_merge(compact('name'), $attr);
        $this->setField('textarea')->getField()->setAttr('maxlength', $length)->setAttributes($attributes);
        $this->setBox(Tag::mk('div'));
        if($label)
            $this->setLabel($label);

        $this->box->appendChild($this->field);

        $uid = $this->uid();
        $nameid = str_replace(['[]', '[', ']'], [$uid, '-', '-'], $name);
        $this->setId(implode('-', ['textarea', $nameid]));
        $this->setValue($value);
    }

    /**
     * 
     * @param string $value
     */
    public function setValue(?string $value): FieldInterface
    {
        $this->value = $value;
        $this->getField()->setContent($this->getValue());
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getValue(): string
    {
        return $this->value ?? '';
    }

}
