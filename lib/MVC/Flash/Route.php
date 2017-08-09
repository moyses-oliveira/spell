<?php

namespace Spell\MVC\Flash;

use Spell\Flash\Path;
use Spell\Flash\Server;
use Spell\MVC\Router\RouteCollection;
use Spell\Server\URS;

/**
 * Description of Route
 *
 * @author moysesoliveira
 */
class Route {
    //put your code here

    /**
     *
     * @var string 
     */
    private static $module = 'home';

    /**
     *
     * @var string 
     */
    private static $action = null;

    /**
     *
     * @var string 
     */
    private static $path = null;

    /**
     *
     * @var \Spell\Server\URS
     */
    private static $urs = null;

    /**
     *
     * @var \Spell\MVC\Router\Route
     */
    private static $route = null;

    /**
     *
     * @var type string
     */
    private static $controller = null;

    /**
     *
     * @var array 
     */
    private static $params = [];

    /**
     *
     * @var \Spell\MVC\Router\RouteCollection 
     */
    private static $collection;

    /**
     * 
     * @param string $path
     * @return \Spell\MVC\Router\Route
     */
    public static function bootstrap(string $path): \Spell\MVC\Router\Route
    {
        static::loadRoute();
        static::setPath($path);
        static::$urs = new URS(static::$route->getUrl());
        list(static::$module, $action) = [static::$urs->getParam(0), static::$urs->getParam(1)];
        
        if(!static::$module)
            static::$module = static::getRoute()->getDefaultMode();

        static::$action = !$action ? 'index' : strtolower($action);

        $urls = array_slice(static::$urs->getParams(), 2);
        static::$params = array_slice($urls, 0);

        $slice = str_replace(['-'], ' ', strtolower(static::$module));
        static::$controller = str_replace(' ', '', ucwords($slice));
        return static::getRoute();
    }

    /**
     * 
     * @return \Spell\MVC\Router\Route
     */
    public static function loadRoute(): \Spell\MVC\Router\Route
    {
        static::$route = static::getCollection()->findByUrl(Server::getAppUri());
        return static::getRoute();
    }

    /**
     * 
     * @return \Spell\MVC\Router\Route
     */
    public static function getRoute(): \Spell\MVC\Router\Route
    {
        return static::$route;
    }

    public static function getAction()
    {
        return static::$action;
    }

    public static function getUrs(): URS
    {
        return static::$urs;
    }

    public static function setPath(string $path)
    {
        static::$path = $path;
    }

    public static function getModule()
    {
        return static::$module;
    }

    public static function getController()
    {
        return static::$controller;
    }

    public static function getPath()
    {
        return static::$path;
    }

    public static function getParam($k)
    {
        return static::getUrs()->getParam($k);
    }

    public static function getParams()
    {
        return static::getUrs()->getParams();
    }

    public static function getIndex()
    {
        return static::getUrs()->getIndex();
    }

    public static function getSite()
    {
        return static::getUrs()->getSite();
    }

    public static function getServerName()
    {
        return static::getUrs()->getServerName();
    }

    public static function getRoot()
    {
        return static::getUrs()->getRoot();
    }

    public static function getSchema()
    {
        return static::getUrs()->getSchema();
    }

    public static function setCollection(RouteCollection $collection)
    {
        static::$collection = $collection;
    }

    public static function getCollection(): RouteCollection
    {
        return static::$collection;
    }

    public static function get(string $key): ?\Spell\MVC\Router\Route
    {
        return static::getCollection()->get($key);
    }

    /**
     * Build url to public path using function arguments
     * 
     * @return string
     */
    public static function trace()
    {
        return static::traceArray(func_get_args());
    }

    /**
     * Build url to public path using array
     * 
     * @return string
     */
    public static function traceArray($path)
    {
        array_unshift($path, 'Public');
        return static::getRoot() . Path::combine($path, '/');
    }

    /**
     * Build link to MVC route using function arguments
     * 
     * @return string
     */
    public static function link()
    {
        return static::linkArray(func_get_args());
    }

    /**
     * Build link to MVC route using function arguments
     * 
     * @return string
     */
    public static function setUrl()
    {
        $path = func_get_args();
        if($path[0] !== false && $path[0] !== Route::getRoot())
            array_unshift($path, Route::getRoot());

        return static::setUrlArray($path);
    }

    /**
     * Build link to MVC route using array
     * 
     * @param array $path
     * @return string
     */
    public static function linkArray($path)
    {
        return static::getSite() . static::setUrlArray($path);
    }

    /**
     * Build link to MVC route using array
     * 
     * @param array $path
     * @return string
     */
    public static function setUrlArray($path)
    {
        return Path::combine($path, '/');
    }

}
