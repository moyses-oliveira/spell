<?php

namespace Spell\UI\HTML;

/**
 *
 * @author moysesoliveira
 */
interface RenderInterface {
    
    /**
     * 
     * @param int $level
     */
    public function render(int $level = 0): string;
}
