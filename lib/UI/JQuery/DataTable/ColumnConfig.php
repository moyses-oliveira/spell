<?php

namespace Spell\UI\JQuery\DataTable;

/**
 * Config of DataTable Column
 *
 * @author moysesoliveira
 */
class ColumnConfig extends AbstractConfig {

    //put your code here
    protected $column = null;
    protected $width = null;
    protected $label = null;
    protected $sort = true;
    protected $actions = [];
    protected $config = [];

    public function __construct($column, $label)
    {
        $this->column = $column;
        $this->label = $label;
    }

    public function sortable($sort)
    {
        $this->sort = $sort;
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function addConfig(string $key, string $value)
    {
        $this->config[$key] = $value;
    }
    
    public function addActions(array $actions){
        foreach($actions as $action)
            $this->addAction($action);
    }

    public function addAction(ActionConfig $action)
    {
        $this->actions[] = $action;
        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getConfig()
    {
        $this->config['mData'] = $this->column;
        $this->config['bSortable'] = $this->sort;
        if($this->actions) :
            $this->config['bSortable'] = false;
            $this->config['actions'] = [];
            foreach($this->actions as $a)
                $this->config['actions'][] = $a->getConfig();

        endif;
        return $this->config;
    }

}
