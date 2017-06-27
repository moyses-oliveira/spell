<?php

namespace Spell\UI\Bootstrap;

/**
 * Description of RadioGroup
 *
 * @author moysesoliveira
 */
class RadioGroup extends \Spell\UI\Data\RadioGroup {

    public function __construct(string $title, string $name, array $options)
    {
        parent::__construct($title, $name, $options);
        $this->getFieldset()->addClass('panel panel-default row');
        $this->getCollectionContainer()->addClass('box-body radio-group');
        $collection = $this->getCollection();
        foreach($collection as &$radio)
            $radio->getBox()->addClass('item');
        
    }

}
