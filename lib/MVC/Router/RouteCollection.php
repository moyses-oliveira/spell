<?php

namespace Spell\MVC\Router;

/**
 * Description of RouteCollection
 *
 * @author moysesoliveira
 */
class RouteCollection {

    /**
     *
     * @var array 
     */
    private $collection = [];

    /**
     * 
     * @param string $key
     * @return \Spell\MVC\Router\Route|null
     */
    public function get(string $key): ?Route
    {
        return $this->collection[$key] ?? null;
    }

    /**
     * 
     * @param string $key
     * @param string $expression
     * @param string $namespace
     * @param string $theme
     * @param string $mode
     */
    public function add(string $key, string $expression, string $namespace, string $theme, string $mode = 'Default')
    {
        $route = new Route($expression, $namespace, $theme, $mode);
        $this->addRoute($key, $route);
    }

    /**
     * 
     * @param string $key
     * @param \Spell\MVC\Router\Route $route
     */
    public function addRoute(string $key, Route $route)
    {
        $this->collection[$key] = $route;
    }

    /**
     * 
     * @param string $url
     * @return \Spell\MVC\Router\Route
     * @throws \Exception
     */
    public function findByUrl(string $url): Route
    {
        foreach($this->collection as $route)
            if($route->check($url))
                return $route;

        throw new \Exception('The application cannot be configurated, no route found.');
    }

}
