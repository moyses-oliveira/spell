<?php

namespace Spell\Data\Inspector\Rule;

/**
 * Description of Email
 *
 * @author moysesoliveira
 */
class Email extends AbstractRule {

    public function __construct()
    {
        $this->setError('EMAIL');
    }

    
    /**
     * data entry can't be null or zero
     * @param string $entry
     * @return bool
     */
    public function validate(?string $entry) : bool {
        return filter_var($entry, FILTER_VALIDATE_EMAIL);
    }
}
