<?php

namespace Spell\UI\JQuery\DataTable;

/**
 * Config of DataTable
 *
 * @author moysesoliveira
 */
class TableConfig extends AbstractConfig {

    protected $dataUrl = null;
    protected $language = null;
    protected $sortDefault = 0;
    protected $desc = true;
    protected $columns = [];
    protected $buttons = [];

    public function __construct(string $dataUrl, $language = 'pt_br')
    {
        $this->dataUrl = $dataUrl;
        $this->language = $language;
    }

    public function createColumn($dataColumn, $label, array $actions = [], array $config = [])
    {
        $column = new ColumnConfig($dataColumn, $label);
        $column->addActions($actions);
        $column->setConfig($config);
        $this->addColumn($column);
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function addColumn(ColumnConfig $column)
    {
        $this->columns[] = $column;
        return $column;
    }

    public function createButton($content, $url)
    {
        $this->addButton(new ButtonConfig($content, $url));
    }

    public function addButton(ButtonConfig $button)
    {
        $this->buttons[] = $button;
    }

    public function setSortDefault($column, $desc = false)
    {
        $this->sortDefault = $column;
        $this->desc = $desc;
    }

    public function getSortDefault()
    {
        return $this->sortDefault;
    }

    public function getSortDesc()
    {
        return $this->desc;
    }

}
