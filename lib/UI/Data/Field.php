<?php

namespace Spell\UI\Data;

use Spell\UI\HTML\Tag;

/**
 * Description of Field
 *
 * @author moysesoliveira
 */
abstract class Field implements FieldInterface {

    /**
     *
     * @var string 
     */
    protected $name = '';

    /**
     *
     * @var string 
     */
    protected $value = null;

    /**
     *
     * @var \Spell\UI\HTML\Tag 
     */
    protected $field = null;

    /**
     *
     * @var \Spell\UI\HTML\Tag 
     */
    protected $label = null;

    /**
     * @var \Spell\UI\HTML\Tag 
     */
    protected $box = null;

    /**
     * @var string
     */
    protected $id = '';

    /**
     * Set name
     * 
     * @param string $name
     * @return \Spell\UI\Data\FieldInterface
     */
    public function setName(string $name): FieldInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function setBox(?Tag $tag): FieldInterface
    {
        $this->box = $tag;
        return $this;
    }

    /**
     * Is required field
     * 
     * @return \Spell\UI\Data\FieldInterface
     */
    public function required(): FieldInterface
    {
        $this->getField()->setAttr('required', true);
        return $this;
    }

    /**
     * Set id attribute of field
     * 
     * @param string $id
     * @return \Spell\UI\Data\FieldInterface
     */
    public function setId(string $id): FieldInterface
    {
        $this->id = $id;
        if($this->label)
            $this->label->setAttr('for', $id);

        $this->field->setAttr('id', $id);
        return $this;
    }

    /**
     * Returns id attribute of field
     * 
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set label name of field and configure label
     * 
     * @return FieldInterface
     */
    public function setLabel(string $label): FieldInterface
    {
        $this->label = Tag::mk('label')->setContent($label);
        if($this->getBox())
            $this->getBox()->preppendChild($this->label);

        return $this;
    }

    /**
     * Remove label
     * 
     * @return FieldInterface
     */
    public function unsetLabel(): FieldInterface
    {
        $this->label = null;
        if($this->getBox())
            $this->getBox()->removeChildByTag('label');

        return $this;
    }

    /**
     * Get label element
     * 
     * @return \Spell\UI\HTML\Tag
     */
    public function getLabel(): ?Tag
    {
        return $this->label;
    }

    /**
     * Set field element tag name
     * 
     * @return \Spell\UI\HTML\Tag
     */
    public function setField($tag): FieldInterface
    {
        $this->field = Tag::mk($tag);
        return $this;
    }

    /**
     * Get field element
     * 
     * @return \Spell\UI\HTML\Tag
     */
    public function getField(): \Spell\UI\HTML\Tag
    {
        return $this->field;
    }

    /**
     * Get box div element
     * 
     * @return \Spell\UI\HTML\Tag
     */
    public function getBox(): ?Tag
    {
        return $this->box;
    }

    /**
     * Render box, div and field element
     * 
     * @return string
     */
    public function render(int $level = 0): string
    {
        if($this->getBox())
            return $this->getBox()->render();

        if($this->label)
            return $this->getLabel()->render() . $this->getField()->render();

        return $this->getField()->render();
    }

    /**
     * Set field value
     * 
     * @param string $value
     */
    public function setValue(?string $value): FieldInterface
    {
        $this->getField()->setAttr('value', $value);
        $this->value = $value;
        return $this;
    }

    /**
     * Get field value
     * 
     * @return string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    
    protected function uid()
    {
        return base_convert(rand(0, intval(pow(10, 10))), 10, 36);
    }
}
