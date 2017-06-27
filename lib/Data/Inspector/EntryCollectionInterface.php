<?php

namespace Spell\Data\Inspector;

use Spell\Data\Inspector\EntryInterface;

/**
 *
 * @author moysesoliveira
 */
interface EntryCollectionInterface {

    /**
     * Set entry
     * 
     * @param string $name
     * @param \Spell\Data\EntryInterface $element
     */
    public function set(EntryInterface $element): EntryInterface;

    /**
     * Entries
     * 
     * @return array
     */
    public function getChilds(): array;

    /**
     * 
     * @param string $name
     * @return \Spell\Data\EntryInterface
     */
    public function get(string $name): EntryInterface;

    /**
     * Validate form entries
     * 
     * @return bool
     */
    public function validate(): bool;

    /**
     * Set entry values from array
     * 
     * @param array $data
     */
    public function fromArray(array $data): EntryCollectionInterface;

    /**
     * Entry error value collection as associative key=>value array
     * 
     * @return array
     */
    public function getErrors(): array;

    /**
     * Entry value collection as associative key=>value array
     * 
     * @return array
     */
    public function toArray(): array;

    /**
     * Entry value collection as array
     * 
     * @return array
     */
    public function normalize(): array;
}
