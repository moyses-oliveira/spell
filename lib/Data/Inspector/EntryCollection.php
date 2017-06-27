<?php

namespace Spell\Data\Inspector;

/**
 * Data Entry Collection
 *
 * @author moysesoliveira
 */
abstract class EntryCollection implements EntryCollectionInterface {

    /**
     *
     * @var array 
     */
    private $childs = [];

    /**
     * 
     * @param string $name
     * @param \Spell\Data\EntryInterface $element
     */
    public function set(EntryInterface $element): EntryInterface
    {
        $this->childs[$element->getName()] = $element;
        return $element;
    }

    /**
     * 
     * @return array
     */
    public function getChilds(): array
    {
        return $this->childs;
    }

    /**
     * 
     * @param string $name
     * @return \Spell\Data\EntryInterface
     */
    public function get(string $name): EntryInterface
    {
        return $this->childs[$name];
    }

    /**
     * Validate form entries
     * 
     * @return bool
     */
    public function validate(): bool
    {
        $valid = true;
        foreach($this->getChilds() as $entry)
            if(!$this->entryValidate($entry))
                $valid = false;

        return $valid;
    }

    /**
     * Validate field entry
     * 
     * @param EntryInterface $entry
     * @return bool
     */
    private function entryValidate(EntryInterface $entry): bool
    {
        return $entry->validate();
    }

    /**
     * Set entry values from array
     * 
     * @param array $data
     */
    public function fromArray(array $data): EntryCollectionInterface
    {
        foreach($this->getChilds() as $key => $entry)
            $this->setEntryValue($entry, $data[$key] ?? null);

        return $this;
    }

    /**
     * Persist entry value
     * 
     * @param EntryInterface $entry
     * @param type $value
     */
    private function setEntryValue(EntryInterface $entry, $value)
    {
        $entry->setValue($value);
    }

    /**
     * Entry error collection as array
     * 
     * @return array
     */
    public function getErrors(): array
    {
        $errors = [];
        foreach($this->getChilds() as $key => $entry):
            if(!$entry->hasError())
                continue;

            $errors[$key] = $entry->getError();
        endforeach;
        return $errors;
    }

    /**
     * Entry value collection as array
     * 
     * @return array
     */
    public function toArray(): array
    {
        $values = [];
        foreach($this->getChilds() as $key => $entry)
            $values[$key] = $entry->getValue();

        return $values;
    }

    /**
     * Entry value collection as array
     * 
     * @return array
     */
    public function normalize(): array
    {
        return $this->toArray();
    }

}
