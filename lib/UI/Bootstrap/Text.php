<?php

namespace Spell\UI\Bootstrap;

/**
 * Text field
 *
 * @author moysesoliveira
 */
class Text extends Input {

    /**
     * 
     * @param string $name
     * @param int $length
     * @param string $label
     * @param string $value
     * @param array $attr
     */
    public function __construct(string $name, int $length, $label = null, $value = null, array $attr = []) {
        parent::__construct($name, Input::TEXT, $label, $value);
        $this->getField()->setAttr('maxlength', $length)->setAttributes($attr);
    }

}
