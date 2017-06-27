<?php

namespace Spell\UI\Data;

/**
 * E-mail field
 *
 * @author moysesoliveira
 */
class Email extends Input {

    /**
     * 
     * @param string $name
     * @param int $length
     * @param string $label
     * @param string $value
     * @param array $attr
     */
    public function __construct(string $name, int $length, $label = null, $value = null, array $attr = []) {
        parent::__construct($name, Input::EMAIL, $label, $value);
        $this->getField()->setAttr('maxlength', $length)->setAttributes($attr);
    }

}
