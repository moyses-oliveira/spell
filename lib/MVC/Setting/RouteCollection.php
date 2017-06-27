<?php

namespace Spell\MVC\Setting;

use Spell\UI\Layout\Theme;

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

    public function add(string $key, string $url, string $namespace, Theme $theme)
    {
        $route = new Route();
        $route->setUrl($url);
        $route->setNamespace($namespace);
        $route->setTheme($theme);
        $this->addRoute($key, $route);
    }

    public function addRoute(string $key, Route $route)
    {
        $this->collection[$key] = $route;
    }

    public function findByUrl(string $url): Route
    {
        foreach($this->collection as $route):
            /* @var $route \Spell\MVC\Setting\Route */
            $routeUrl = $route->getUrl();
            if(substr(strtolower($url), 0, strlen($routeUrl)) === $routeUrl)
                return $route;

        endforeach;

        throw new \Exception('The application cannot be configurated, no route found.');
    }

}
