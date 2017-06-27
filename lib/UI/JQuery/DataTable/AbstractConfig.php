<?php

namespace Spell\UI\JQuery\DataTable;

/**
 * DataTable core Config
 *
 * @author moysesoliveira
 */
abstract class AbstractConfig
{

    public function getConfig()
    {
        $config = [];
        foreach ($this as $k => $v)
            $config[$k] = $this->getConfigFromMixed($v);

        return $config;
    }

    private function getConfigFromMixed($v)
    {
        if (is_array($v)):
            $configs = [];
            foreach ($v as $i)
                $configs[] = $i->getConfig();

            return $configs;
        endif;

        return is_object($v) ? $v->getConfig() : $v;
    }

}
