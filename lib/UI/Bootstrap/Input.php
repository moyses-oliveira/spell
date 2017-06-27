<?php

namespace Spell\UI\Bootstrap;

use Spell\UI\HTML\Tag;

/**
 * Styled bootstrap input
 *
 * @author moysesoliveira
 */
abstract class Input extends \Spell\UI\Data\Input {

    public function stylize() {
        $this->getBox()->addClass('form-group');
        $this->getField()->addClass('form-control');
        if($this->getLabel() && $this->getField()->hasAttr('required'))
            $this->getLabel()->addClass('required');
        
        $this->getBox()->appendChild(Tag::mk('div')->addClass('form-error-message'));
    }
    
    public function render(int $level = 0): string
    {
        $this->stylize();
        return parent::render();
    }

}
