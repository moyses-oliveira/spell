<?php

namespace Spell\UI\Layout;

/**
 * Description of AbstractView
 *
 * @author moyses-oliveira
 */
abstract class AbstractView
{

    use Data;

    /**
     * @return array
     */
    public function header($code = 200)
    {
        http_response_code($code);
        header('Content-type: text/html; charset=utf-8');
        return $this;
    }

    /**
     * 
     * @param string $file
     */
    protected function fileRender($file)
    {
        ob_start();
        extract($this->data);
        require $file;
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

}
