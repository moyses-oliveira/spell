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
        return trim(strtolower(static::getName() . static::getUri()), '/');
    }

    public static function getPort()
    {
        return $_SERVER['SERVER_PORT'];
    }

    public static function getName(bool $port = true)
    {
        return $port ? $_SERVER['HTTP_HOST'] : strstr($_SERVER['HTTP_HOST'], ':', true);
    }

    public static function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

}
