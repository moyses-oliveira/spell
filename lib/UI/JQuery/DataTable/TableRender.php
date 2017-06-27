<?php

namespace Spell\UI\JQuery\DataTable;

/**
 * Render Datatable HTML
 *
 * @author moysesoliveira
 */
class TableRender
{

    private $dtTbConfig = null;
    private $dtTbId = null;

    public function __construct(TableConfig $dtTbConfig, $dtTbId = 'app-data-table-config')
    {
        $this->dtTbConfig = $dtTbConfig;
        $this->dtTbId = $dtTbId;
    }

    public function renderJson()
    {
        $json = json_encode($this->dtTbConfig->getConfig(), JSON_PRETTY_PRINT);
        return PHP_EOL . '<script type="application/json" id="' . $this->dtTbId . '">' . PHP_EOL . $json . PHP_EOL . '</script>';
    }

    public function renderHtmlTable()
    {
        $th = '';
        $sortDefault = $this->dtTbConfig->getSortDefault();
        $orientation = $this->dtTbConfig->getSortDesc() ? 'desc' : 'asc';

        foreach ($this->dtTbConfig->getColumns() as $c)
            $th .= PHP_EOL . str_repeat("\t", 4) . '<th>' . $c->getLabel() . '</th>';

        return <<<HTML
		
<div class="form-group" app-config="#{$this->dtTbId}" data-spell_data_table="true">
	<div class="navbar-header col-xs-12">
	</div>
	<div style="clear: both;"></div><br/>
	<table class="data table table-bordered table-hover" data-order='[[$sortDefault, "$orientation" ]]'>
		<thead>
			<tr class="stylegrids data-table-header">$th
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
		
HTML;
    }

    public function render()
    {
        return $this->renderJson() . $this->renderHtmlTable();
    }

}
