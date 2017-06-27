<?php

namespace Spell\UI\Bootstrap;


/**
 * Description of Input
 *
 * @author moysesoliveira
 */
class Submit extends \Spell\UI\Data\Button {

    public function __construct(string $name, string $content, string $value, $attr = array()) {
        parent::__construct($name, 'submit', $content, $value, $attr);
    }

    public function stylize() {
        $this->getField()->setClasses(['btn' ,'btn-primary', 'pull-right']);
    }
    
    public function render(int $level = 0): string
    {
        $this->stylize();
        return parent::render();
    }
}
