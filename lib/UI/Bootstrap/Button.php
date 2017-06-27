<?php

namespace Spell\UI\Bootstrap;


/**
 * Description of Input
 *
 * @author moysesoliveira
 */
class Button extends \Spell\UI\Data\Button {

    public function __construct(string $name, string $content, string $value, $attr = array()) {
        parent::__construct($name, 'button', $content, $value, $attr);
    }

    public function stylize() {
        $this->getField()->setClasses(['btn']);
    }
    
    public function render(): string
    {
        $this->stylize();
        return parent::render();
    }
}
