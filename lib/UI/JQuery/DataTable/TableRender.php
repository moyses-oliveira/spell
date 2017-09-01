<?php

namespace Spell\UI\JQuery\DataTable;

use Spell\UI\HTML\Tag;
/**
 * Render Datatable HTML
 *
 * @author moysesoliveira
 */
class TableRender
{

    /**
     *
     * @var TableConfig 
     */
    private $dtTbConfig = null;
    
    /**
     *
     * @var Tag
     */
    private $container = null;
    
    /**
     *
     * @var string 
     */
    private $dtTbId = null;
    
    /**
     *
     * @var bool
     */
    private $autoInvoke = true;

    public function __construct(TableConfig $dtTbConfig, $dtTbId = 'app-data-table-config')
    {
        $this->dtTbConfig = $dtTbConfig;
        $this->dtTbId = $dtTbId;
        $this->container = Tag::div();
    }
    
    public function setAutoInvoke(bool $bool) {
        $this->autoInvoke = $bool;
    }
    
    public function getAutoInvoke():bool {
        return $this->autoInvoke;
    }
    
    public function getContainer(): Tag {
        return $this->container;
    }

    public function renderJson()
    {
        $json = json_encode($this->dtTbConfig->getConfig(), JSON_PRETTY_PRINT);
        return Tag::mk('script')
            ->setAttr('type', 'application/json')
            ->setAttr('id', $this->dtTbId)
            ->setContent(PHP_EOL . $json . PHP_EOL)
            ->render();
    }

    public function renderHtmlTable()
    {
        
        $body = $this->getContainer();
        $body->addClass('form-group');
        $body->setAttr('app-config', "#{$this->dtTbId}");
        
        if($this->getAutoInvoke())
            $body->setAttr('data-spell_data_table', '1');
        
        $body->appendChild(Tag::div('navbar-header col-xs-12'));
        $body->appendChild(Tag::div('clearfix')->setContent('&nbsp;'));
        
        $sortDefault = $this->dtTbConfig->getSortDefault();
        $orientation = $this->dtTbConfig->getSortDesc() ? 'desc' : 'asc';

        $th = new \ArrayObject();
        foreach ($this->dtTbConfig->getColumns() as $c)
            $th->append(Tag::mk('th')->setContent($c->getLabel()));
        
        $headerRow = Tag::mk('tr', 'stylegrids data-table-header')->setChilds($th->getArrayCopy());
        
        $table = Tag::mk('table', 'data table table-bordered table-hover')
            ->setAttr('data-order', sprintf('[[%s, "%s" ]]', $sortDefault, $orientation));
        
        $table->appendChild(Tag::mk('thead')->appendChild($headerRow));
        $table->appendChild(Tag::mk('tbody'));
        return $body->appendChild($table)->render();
    }

    public function render()
    {
        return $this->renderJson() . $this->renderHtmlTable();
    }

}
