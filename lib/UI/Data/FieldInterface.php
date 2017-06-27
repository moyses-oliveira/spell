<?php

namespace Spell\UI\Data;

use Spell\UI\HTML\Tag;
use Spell\UI\HTML\RenderInterface;

/**
 *
 * @author moysesoliveira
 */
interface FieldInterface extends RenderInterface {

    /**
     * Set name
     * 
     * @param string $name
     * @return \Spell\UI\Data\FieldInterface
     */
    public function setName(string $name): FieldInterface;

    /**
     * Get name
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Is required field
     * 
     * @return \Spell\UI\Data\FieldInterface
     */
    public function required(): FieldInterface;

    /**
     * Set id attribute of field
     * 
     * @param string $id
     * @return \Spell\UI\Data\FieldInterface
     */
    public function setId(string $id): FieldInterface;

    /**
     * Returns id attribute of field
     * 
     * @return string
     */
    public function getId(): ?string;

    /**
     * Set label name of field and configure label
     * 
     * @return FieldInterface
     */
    public function setLabel(string $label): FieldInterface;

    /**
     * Remove label
     * 
     * @return FieldInterface
     */
    public function unsetLabel(): FieldInterface;

    /**
     * Get label element
     * 
     * @return \Spell\UI\HTML\Tag
     */
    public function getLabel(): ?\Spell\UI\HTML\Tag;

    /**
     * Set field element tag name
     * 
     * @return \Spell\UI\HTML\Tag
     */
    public function setField($tag): FieldInterface;

    /**
     * Get field element
     * 
     * @return \Spell\UI\HTML\Tag
     */
    public function getField(): \Spell\UI\HTML\Tag;

    /**
     * Set field box container
     * 
     * @param Tag|null $tag
     * @return \Spell\UI\Data\FieldInterface
     */
    public function setBox(?Tag $tag): FieldInterface;

    /**
     * Get box div element
     * 
     * @return \Spell\UI\HTML\Tag
     */
    public function getBox(): ?\Spell\UI\HTML\Tag;

    /**
     * Set field value
     * 
     * @param string $value
     */
    public function setValue(?string $value): FieldInterface;

    /**
     * Get field value
     * 
     * @return string
     */
    public function getValue(): ?string;
}
