<?php

/**
 *  
 * @author Moysés Filipe Lopes Peixoto de Oliveira
 * @version 1.0
 * @access public
 * @modification 2016-10-20
 */

namespace Spell\UI\HTML;

class HTML5 extends AbstractTag
{
    
    public static function start(){
        return (new self('html'))->open();
    }
    
    public static function end() {
        return (new self('html'))->close();
    }


    public function open($eol = true)
    {
        $el = ($eol ? PHP_EOL : '');
        return '<!DOCTYPE html>' . $el . '<html>' . $el;
    }
}
