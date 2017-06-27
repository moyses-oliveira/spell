<?php

namespace Spell\UI\Data;

use Spell\UI\HTML\Tag;
use Spell\UI\Data\FieldInterface;
use Spell\UI\HTML\RenderInterface;

/**
 *
 * @author moysesoliveira
 */
interface FormInterface extends RenderInterface {

    /**
     * Set field
     * 
     * @param string $name
     * @param \Spell\UI\Data\FieldInterface $element
     */
    public function set(FieldInterface $element): FieldInterface;

    /**
     * Entries
     * 
     * @return array
     */
    public function getChilds(): array;

    /**
     * Get field
     * 
     * @param string $name
     * @return \Spell\UI\Data\FieldInterface
     */
    public function get(string $name): FieldInterface;

    /**
     * Entry value collection as associative key=>value array
     * 
     */
    public function fromArray(array $data);

    /**
     * Entry value collection as associative key=>value array
     * 
     * @return array
     */
    public function toArray(): array;

    /**
     * Element Tag
     * 
     * @return Tag
     */
    public function getElement(): Tag;

    /**
     * Open form string render
     * 
     * @return string
     */
    public function open(): string;

    /**
     * Close form string render
     * 
     * @return string
     */
    public function close(): string;
}
