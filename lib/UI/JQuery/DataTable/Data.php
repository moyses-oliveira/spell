<?php

namespace Spell\UI\JQuery\DataTable;

/**
 * Description of Data
 *
 * @author moysesoliveira
 */
class Data
{
    private $data = null;

    private $recordsFiltered = null;
    
    private $recordsTotal = null;
    
    public function setData($data) {
        $this->data = $data;
        return $this;
    }
    
    public function setRecordsFiltered($recordsFiltered) {
        $this->recordsFiltered = $recordsFiltered;
        return $this;
    }
    
    public function setRecordsTotal($recordsTotal) {
        if(empty($this->recordsFiltered))
            $this->recordsFiltered = $recordsTotal;
        
        $this->recordsTotal = $recordsTotal;
        return $this;
    }

    public function toArray(){
        $array = [];
		foreach($this as $k=>$v)
            $array[$k] = $v;
        
        return $array;
    }
}
