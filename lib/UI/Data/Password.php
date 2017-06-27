<?php

namespace Spell\UI\Data;

/**
 * Password field
 *
 * @author moysesoliveira
 */
class Password extends Input {

    /**
     * 
     * @param string $name
     * @param int $length
     * @param string $label
     * @param string $value
     * @param array $attr
     */
    public function __construct(string $name, int $length, $label = null, $value = null, $attr = []) {
        parent::__construct($name, Input::PASS, $label, $value);
        $this->getField()->setAttr('maxlength', $length)->setAttributes($attr);
    }

}
