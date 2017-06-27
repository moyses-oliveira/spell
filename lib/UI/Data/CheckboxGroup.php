<?php

namespace Spell\UI\Data;

use Spell\UI\HTML\Tag;
use Spell\UI\HTML\RenderInterface;

/**
 * Description of CheckboxGroup
 *
 * @author moysesoliveira
 */
class CheckboxGroup implements RenderInterface {

    /**
     *
     * @var Tag 
     */
    private $fieldset = null;

    /**
     *
     * @var Tag 
     */
    private $legend = null;

    /**
     *
     * @var Tag 
     */
    private $collectionContainer = null;

    /**
     *
     * @var string 
     */
    private $title = null;

    /**
     *
     * @var array 
     */
    private $collection = [];

    /**
     *
     * @var array 
     */
    private $values = [];

    public function __construct(string $title, string $name, array $options)
    {
        $this->setTitle($title);
        $this->fieldset = Tag::mk('fieldset');
        $this->collectionContainer = Tag::mk('div');
        $this->legend = Tag::mk('legend')->setContent($this->getTitle());
        $this->getFieldset()->appendChild($this->legend);
        $this->getFieldset()->appendChild($this->getCollectionContainer());

        foreach($options as $k => $v)
            $this->collection[] = new Checkbox($name . '[]', $k, $v, false);
    }

    public function append(Checkbox $checkbox): CheckboxGroup
    {
        $this->collection[] = $checkbox;
        return $this;
    }

    public function preppend(Checkbox $checkbox): CheckboxGroup
    {
        array_unshift($this->collection, $checkbox);
        return $this;
    }

    public function getFieldset(): Tag
    {
        return $this->fieldset;
    }

    public function setTitle(string $title): CheckboxGroup
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setValues(array $values): CheckboxGroup
    {
        $this->values = $values;
        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getLegend(): Tag
    {
        return $this->legend;
    }

    public function getCollectionContainer(): Tag
    {
        return $this->collectionContainer;
    }

    public function getCollection(): array
    {
        return $this->collection;
    }

    public function render(int $level = 0): string
    {
        $this->mergeCollection();
        return $this->getFieldset()->render();
    }

    protected function mergeCollection()
    {
        foreach($this->getCollection() as $checkbox):
            /* @var $checkbox \Spell\UI\Data\Checkbox */
            if(in_array($checkbox->getField()->getAttr('value'), $this->getValues()))
                $checkbox->getField()->setAttr('checked');

            $this->getCollectionContainer()->appendChild($checkbox->getBox());
        endforeach;
    }

}
