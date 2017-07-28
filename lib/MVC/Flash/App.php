<?php

namespace Spell\MVC\Flash;

/**
 * Description of Spell\App
 *
 * @author moysesoliveira
 */
class App {

    /**
     *
     * @var string
     */
    private static $root = null;

    /**
     *
     * @var string
     */
    private static $route = null;

    /**
     *
     * @var string 
     */
    private static $alias = null;

    /**
     *
     * @var string 
     */
    private static $path = null;

    /**
     *
     * @var string 
     */
    private static $namespace = null;

    /**
     * 
     * @param \Spell\MVC\Router\Route $route
     */
    public static function configure(\Spell\MVC\Router\Route $route, string $root)
    {
        static::$root = $root;
        static::$route = $route->getUrl();
        static::$alias = $route->getNamespace();
        static::$path = 'App/' . static::$alias . '/';
        static::$namespace = str_replace('/', '\\', static::$path);
    }

    public static function getRoot()
    {
        return static::$root;
    }

    public static function getRoute()
    {
        return static::$route;
    }

    public static function getAlias()
    {
        return static::$alias;
    }

    public static function getPath()
    {
        return static::$path;
    }

    public static function getNamespace()
    {
        return static::$namespace;
    }

}
