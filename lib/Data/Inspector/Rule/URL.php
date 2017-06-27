<?php

namespace Spell\Data\Inspector\Rule;

/**
 * Email
 *
 * @author moysesoliveira
 */
class URL extends AbstractRule {

    public function __construct()
    {
        $this->setError('URL');
    }
    
    /**
     * data entry can't be null or zero
     * @param string $entry
     * @return bool
     */
    public function validate(?string $entry) : bool {
        return filter_var($entry, FILTER_VALIDATE_URL, FILTER_FLAG_HOSTNAME);
    }
}
