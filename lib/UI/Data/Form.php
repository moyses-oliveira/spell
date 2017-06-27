<?php

/**
 * HTML Form Class
 *  
 * @author Moysés Filipe Lopes Peixoto de Oliveira
 * @version 1.0
 * @access public
 * @modification 2016-10-20
 */

namespace Spell\UI\Data;

use Spell\UI\HTML\Tag;
use Spell\Data\Inspector\EntryCollectionInterface;
use Spell\UI\Data\FieldInterface;
use Spell\UI\HTML\RenderInterface;

class Form implements FormInterface {

    /**
     *
     * @var \Spell\UI\HTML\Tag 
     */
    private $element = null;

    /**
     * 
     * @param EntryCollectionInterface $collection
     * @param string $name
     * @param string|null $action
     * @param array $attr
     */
    public function __construct(string $name, ?string $action = null, array $attr = [])
    {
        $this->element = Tag::mk('form');
        $attr['method'] = $attr['method'] ?? 'post';
        $attr['enctype'] = $attr['enctype'] ?? 'multipart/form-data';
        $attributes = array_merge(compact('name', 'action'), $attr);
        $this->element->setAttributes($attributes);
    }

    /**
     * Set field
     * 
     * @param string $name
     * @param \Spell\UI\Data\FieldInterface $element
     */
    public function set(FieldInterface $element): FieldInterface
    {
        $this->addChild($element->getName(), $element);
        return $element;
    }

    /**
     * Set field
     * 
     * @param string $key
     * @param \Spell\UI\Data\FieldInterface $element
     */
    public function addChild(string $key, RenderInterface $element): FormInterface
    {
        $this->childs[$key] = $element;
        return $this;
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
     * Get field
     * 
     * @param string $name
     * @return \Spell\UI\Data\FieldInterface
     */
    public function get(string $name): FieldInterface
    {
        return $this->childs[$name];
    }

    /**
     * Set form values from array
     * 
     * @param array $data
     */
    public function fromArray(array $data): Form
    {
        foreach($this->getChilds() as $key => $field)
            if(isset($data[$key]))
                $this->setFieldValue($field, $data[$key]);

        return $this;
    }

    /**
     * Persist entry value
     * 
     * @param FieldInterface $field
     * @param string|null $value
     */
    public function setFieldValue(FieldInterface $field, ?string $value)
    {
        $field->setValue($value);
    }

    /**
     * Entry value collection as associative key=>value array
     * 
     * @return array
     */
    public function toArray(): array
    {
        $values = [];
        foreach($this->getChilds() as $key => $field)
            $values[$key] = $field->getValue();

        return $values;
    }

    /**
     * Element Tag
     * 
     * @return Tag
     */
    public function getElement(): Tag
    {
        return $this->element;
    }

    /**
     * Open form string render
     * 
     * @return string
     */
    public function open(): string
    {
        return $this->element->open();
    }

    /**
     * Close form string render
     * 
     * @return string
     */
    public function close(): string
    {
        return $this->element->close();
    }

    /**
     * 
     * @param integer $level
     * @return string
     */
    protected function renderChilds(int $level = 0): string
    {
        $content = '';
        foreach($this->childs as $child)
            if(is_array($child)):
                throw \Exception('Child can\'t be array.');
            elseif(is_object($child)):
                $content .= $this->renderChild($child, $level + 1);
            else:
                $content .= $child;
        endif;

        return $content;
    }

    /**
     * 
     * @param mixed $child
     * @param integer $level
     * @return string
     */
    protected function renderChild(RenderInterface $child, int $level = 0)
    {
        return $child->render($level + 1);
    }

    /**
     * 
     * @param int $level
     * @return string
     */
    public function render(int $level = 0): string
    {
        return $this->open() . PHP_EOL . $this->renderChilds($level) . PHP_EOL . $this->close();
    }

}
