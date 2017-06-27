<?php

namespace Spell\Data\Inspector\Rule;

/**
 * Rule
 *
 * @author moysesoliveira
 */
abstract class AbstractRule implements RuleInterface {

    /**
     *
     * @var string 
     */
    private $error = null;

    /**
     *
     * @var array 
     */
    private $errorParams = [];

    /**
     * 
     * @return string
     */
    public function hasError(): bool
    {
        return !empty($this->error);
    }

    /**
     * 
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * 
     * @param string $error
     */
    public function setError(string $error)
    {
        $this->error = $error;
    }

    /**
     * Set params of error message
     * 
     * @param string $errorParams
     */
    public function setErrorParams(array $errorParams)
    {
        $this->errorParams = $errorParams;
    }

    /**
     * Get params of error message
     * 
     * @return array
     */
    public function getErrorParams(): array
    {
        return $this->errorParams;
    }

    /**
     * 
     * @param string $entry
     * @param string $expression
     * @return bool
     */
    protected function regex(string $entry, string $expression): bool
    {
        return empty($entry) || !!filter_var($entry, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $expression]]);
    }

    /**
     * data entry can't be null or zero
     * @param string $entry
     * @return bool
     */
    public abstract function validate(?string $entry): bool;
}
