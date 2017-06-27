<?php

namespace Spell\Data\Inspector\Rule;

/**
 * Description of Email
 *
 * @author moysesoliveira
 */
class Length extends AbstractRule {

    public function __construct(int $length)
    {
        $this->setErrorParams([$length]);
        $this->setError('LENGTH');
    }

    
    /**
     * data entry can't be null or zero
     * @param string $entry
     * @return bool
     */
    public function validate(?string $entry) : bool {
        $length = $this->getErrorParams()[0];
        if(!$length || !$entry)
            return true;
        
        return strlen($entry) <= $length;
    }
}
