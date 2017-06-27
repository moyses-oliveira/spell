<?php

namespace Spell\Flash;

/**
 * Description of Server
 *
 * @author moysesoliveira
 */
class Server
{

    //put your code here
    public static function getAppUri()
    {
        $p = static::getPort();
        return trim(strtolower(static::getName() . ($p == 80 ? '' : ':' . $p) . static::getUri()), '/');
    }

    public static function getPort()
    {
        return $_SERVER['SERVER_PORT'];
    }

    public static function getName()
    {
        return $_SERVER['SERVER_NAME'];
    }

    public static function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

}
