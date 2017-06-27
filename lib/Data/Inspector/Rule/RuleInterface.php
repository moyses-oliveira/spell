<?php

namespace Spell\Data\Inspector\Rule;

/**
 * Rule
 *
 * @author moysesoliveira
 */
interface RuleInterface {

    /**
     * 
     * @return string
     */
    public function getError() : string;

    /**
     * Check if has error
     */
    public function hasError(): bool;

    /**
     * 
     * @param string $error
     */
    public function setError(string $error);

    /**
     * Set params of error message
     * 
     * @param string $errorParams
     */
    public function setErrorParams(array $errorParams);

    /**
     * Get params of error message
     * 
     * @return array
     */
    public function getErrorParams(): array;
    
    /**
     * 
     * @param string $entry
     */
    public function validate(?string $entry): bool;
}
