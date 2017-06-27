<?php

namespace Spell\UI\JQuery\DataTable;

/**
 * Config of DataTable Actions at some Column
 *
 * @author moysesoliveira
 */
class ActionConfig extends AbstractConfig
{

    const LINK = 'link';
    const CONFIRM = 'confirm';

    //put your code here
    protected $url = null;
    protected $mode = null;
    protected $title = null;
    protected $icon = null;
    protected $cls = null;
    protected $confirm = null;
    protected $activeParam = null;

    public function __construct($url, $icon, $title, $cls, $confirm = null)
    {

        $this->url = $url;
        $this->mode = !$confirm ? static::LINK : static:: CONFIRM;
        $this->title = $title;
        $this->icon = $icon;
        $this->cls = $cls;
        $this->confirm = $confirm;
    }

    public function setActiveParam($cp)
    {
        $this->activeParam = $cp;
    }

}
