<?php

namespace Spell\UI\Layout;

/**
 * Description of Json
 *
 * @author moysesoliveira
 */
class Json
{

    use Data;

    /**
     * @return array
     */
    public function header($code = 200)
    {
        http_response_code($code);
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json; charset=utf-8');
        return $this;
    }

    /**
     * @return array
     */
    public function render()
    {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }

}
