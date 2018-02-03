<?php

namespace Spell\UI\Data;

use Spell\UI\HTML\Tag;

/**
 * Description of RadioGroup
 *
 * @author moysesoliveira
 */
class RadioGroup implements \Spell\UI\HTML\RenderInterface {

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
     * @var string 
     */
    private $value = '';

    public function __construct(string $title, string $name, array $options, ?string $value = null)
    {
        $this->setTitle($title);
        $this->fieldset = Tag::mk('fieldset');
        $this->collectionContainer = Tag::mk('div');
        $this->legend = Tag::mk('legend')->setContent($this->getTitle());
        $this->getFieldset()->appendChild($this->legend);
        $this->getFieldset()->appendChild($this->getCollectionContainer());
        $this->setValue($value);
        foreach($options as $k => $v)
            $this->collection[] = new Radio($name, $k, $v, false);
    }

    public function append(Radio $radio): RadioGroup
    {
        $this->collection[] = $radio;
        return $this;
    }

    public function preppend(Radio $radio): RadioGroup
    {
        array_unshift($this->collection, $radio);
        return $this;
    }

    public function getFieldset(): Tag
    {
        return $this->fieldset;
    }

    public function setTitle(string $title): RadioGroup
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setValue(?string $value): RadioGroup
    {
        $this->value = $value;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
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
    
    protected function mergeCollection(){
        foreach($this->getCollection() as $radio):
            /* @var $radio \Spell\UI\Data\Radio */
            if($this->getValue() !== null && $radio->getField()->getAttr('value') === $this->getValue())
               $radio->getField()->setAttr('checked'); 
                
            $this->getCollectionContainer()->appendChild($radio->getBox());
        endforeach;
        
    }

}
