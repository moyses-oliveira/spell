<?php

namespace Spell\MVC\Setting;

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

    public function add(string $key, string $url, string $namespace, string $theme)
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
        foreach($this->collection as $route)
            if($this->routeCheck($url, $route->getUrl()))
                return $route;

        throw new \Exception('The application cannot be configurated, no route found.');
    }
    
    private function routeCheck($entry, $expression) {
        if(substr($expression, 0, 2) !== '/^')
            return substr(strtolower($entry), 0, strlen($expression)) === $expression;
        
        return !!filter_var($entry, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $expression]]);
    }

}
