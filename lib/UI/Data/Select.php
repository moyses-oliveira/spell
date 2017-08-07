<?php

namespace Spell\UI\Data;

use Spell\UI\HTML\Tag;

/**
 * Description of Input
 *
 * @author moysesoliveira
 */
class Select extends Field {

    /**
     *
     * @var array 
     */
    private $options = [];

    /**
     *
     * @var string 
     */
    protected $emptyOption = null;

    /**
     * 
     * @param string $name
     * @param array $options
     * @param string|null $label
     * @param string|null $emptyOption
     * @param string $value
     */
    public function __construct(string $name, array $options, ?string $label = null, ?string $emptyOption = '', string $value = '')
    {
        $this->setName($name);
        $this->setField('select')->getField()->setAttributes(compact('name'));
        $uid = base_convert(rand(0, intval(pow(10, 10))), 10, 36);
        $nameid = str_replace(['[]', '[', ']'], [$uid, '-', '-'], $name);
        $this->box = Tag::mk('div');
        if($label)
            $this->setLabel($label);

        $this->setId(implode('-', ['select', $nameid]));
        $this->box->appendChild($this->field);
        $this->setEmptyOption($emptyOption);
        $this->setOptions($options);
        $this->setValue($value);
    }

    /**
     * 
     * @param string|null $emptyOption
     * @return \Spell\UI\Data\FieldInterface
     */
    public function setEmptyOption(?string $emptyOption): FieldInterface
    {
        $this->emptyOption = $emptyOption;
        return $this;
    }
    
    /**
     * 
     * @param string $value
     */
    public function setValue(?string $value): FieldInterface
    {
        foreach($this->options as &$option):
            /* @var $option Tag */
            $option->removeAttr('selected');
        endforeach;

        if(isset($this->options[$value])):
            /* @var $option Tag */
            $option = &$this->options[$value];
            $option->setAttr('selected');
        endif;

        $this->getField()->setAttr('value', $value);
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getValue(): string
    {
        return $this->getField()->getAttr('value');
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = [];
        foreach($options as $k => $v)
            $this->addOption(is_numeric($k) ? (string) $k : $k, is_numeric($v) ? (string) $v : $v);
        
        return $this;
    }

    /**
     * 
     * @param string $k
     * @param string $v
     */
    private function addOption(string $k, string $v)
    {
        $this->addOptionTag($k, Tag::mk('option')->setAttr('value', $k)->setContent($v));
    }

    /**
     * 
     * @param type $k
     * @param Tag $option
     * @return $this
     */
    private function addOptionTag($k, Tag $option)
    {
        $this->options[$k] = $option;
        return $this;
    }

    /**
     * 
     * @return 
     */
    public function getOptions(): array
    {
        $options = [];
        foreach($this->options as $k => $v)
            $options[$k] = $v->getChild(0);

        return $options;
    }

    /**
     * 
     * @return string
     */
    public function render(int $level = 0): string
    {
        $this->getField()->setChilds($this->options);
        if($this->emptyOption)
            $this->getField()->preppendChild(Tag::mk('option')->setAttr('value', '')->setContent($this->emptyOption));
        
        return parent::render();
    }

}
