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

    public function get(string $key): ?Route
    {
        return $this->collection[$key] ?? null;
    }

    public function add(string $key, string $expression, string $namespace, string $theme, string $mode = 'Default')
    {
        $route = new Route($expression, $namespace, $theme, $mode);
        $this->addRoute($key, $route);
    }

    public function addRoute(string $key, Route $route)
    {
        $this->collection[$key] = $route;
    }

    public function findByUrl(string $url): Route
    {
        foreach($this->collection as $route)
            if($route->check($url))
                return $route;

        throw new \Exception('The application cannot be configurated, no route found.');
    }

}
