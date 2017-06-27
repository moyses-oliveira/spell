<?php

namespace Spell\Data\Inspector\Rule;

/**
 * Domain Name
 *
 * @author moysesoliveira
 */
class DomainName extends AbstractRule {

    public function __construct()
    {
        $this->setError('DOMAIN_NAME');
    }
    
    /**
     * data entry can't be null or zero
     * @param string $entry
     * @return bool
     */
    public function validate(?string $entry) : bool {
        return filter_var($entry, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
    }
}
