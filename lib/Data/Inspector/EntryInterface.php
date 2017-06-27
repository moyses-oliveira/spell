<?php

namespace Spell\Data\Inspector;

use Spell\Data\Inspector\Rule\RuleInterface;

/**
 *
 * @author moysesoliveira
 */
interface EntryInterface {

    /**
     * 
     * @param string $name
     * @param string|null $value
     */
    public function __construct(string $name, int $length, ?string $value = null);

    /**
     * Set name
     * 
     * @param string $name
     * @return \Spell\UI\Data\EntryInterface
     */
    public function setName(string $name): EntryInterface;

    /**
     * Get name
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Data set value
     */
    public function setError(string $value);

    /**
     * Check if has error
     */
    public function hasError(): bool;

    /**
     * Data entry get value
     */
    public function getError(): ?string;

    /**
     * Data set value
     */
    public function setValue(?string $value): EntryInterface;

    /**
     * Data entry get value
     */
    public function getValue(): ?string;

    /**
     * Data entry add multiple rules
     */
    public function setRules(array $rules): EntryInterface;

    /**
     * Data entry add rule
     */
    public function addRule(RuleInterface $rules): EntryInterface;

    /**
     * Data entry get rules
     */
    public function getRules(): array;

    /**
     * Is required
     * 
     * @return \Spell\Data\Inspector\EntryInterface
     */
    public function isRequired(): EntryInterface;

    /**
     * Entry max length
     * 
     * @param int $length
     * @return \Spell\Data\Inspector\EntryInterface
     */
    public function length(int $length): EntryInterface;

    /**
     * Check data entry validity
     */
    public function validate(): bool;
}
