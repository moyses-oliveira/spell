<?php

namespace Spell\UI\Bootstrap;

/**
 * Description of CheckboxGroup
 *
 * @author moysesoliveira
 */
class CheckboxGroup extends \Spell\UI\Data\CheckboxGroup {

    public function __construct(string $title, string $name, array $options)
    {
        parent::__construct($title, $name, $options);
        $this->getFieldset()->addClass('panel panel-default');
        $this->getCollectionContainer()->addClass('panel-body checkbox-group');
        $collection = $this->getCollection();
        foreach($collection as &$checkbox)
            $checkbox->getBox()->addClass('item');
        
    }

}
