<?php

namespace Spell\Data\Inspector\Rule;

/**
 * Data entry is mandatory
 *
 * @author moysesoliveira
 */
class Required extends AbstractRule {

    public function __construct()
    {
        $this->setError('REQUIRED');
    }

    /**
     * data entry can't be null or zero
     * @param string $entry
     * @return bool
     */
    public function validate(?string $entry): bool
    {
        if(is_numeric($entry))
            return floatval($entry) != 0;
        
        return $entry !== null && strlen($entry) > 0;
    }

}
