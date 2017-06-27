<?php

namespace Spell\UI\JQuery;

/**
 * Description of UIV
 *
 * @author moysesoliveira
 */
class UIV {

    private $variables = [];

    public function set(array $variables)
    {
        $this->variables = $variables;
    }

    public function get(): array
    {
        return $this->variables;
    }

    public function add($key, $value): UIV
    {
        $this->variables[$key] = $value;
        return $this;
    }

    public function remove($key)
    {
        unset($this->variables[$key]);
    }

    public function reset()
    {
        $this->variables = [];
    }

}
