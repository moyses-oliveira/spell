<?php

namespace Spell\UI\JQuery\DataTable;

/**
 * Button for datatable
 *
 * @author moysesoliveira
 */
class ButtonConfig extends AbstractConfig
{

    protected $content = '';
    protected $url = '';

    public function __construct($content, $url)
    {
        $this->content = $content;
        $this->url = $url;
    }

}
