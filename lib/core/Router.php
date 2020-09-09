<?php
namespace Core;

class Router
{
    protected $routes = [];

    /**
     * This method add a route to the routes list.
     *
     * @param Route $route Route to be added to the list.
     *
     * @return null
     */
    public function addRoute(Route $route)
    {
        if (!in_array($route, $this->routes)) {
            $this->routes[] = $route;
        }
    }

    /**
     * This method take a URL and returns the matched route.
     * 
     * @param string $url The URL to be matched
     * 
     * @return Route
     */
    public function getRoute($url)
    {
        foreach ($this->routes as $route) {
            if (($varsValues = $route->match($url)) !== false) {
                if ($route->hasVars()) {
                    $varsNames = $route->varNames();
                    $vars = [];

                    foreach ($varsValues as $key => $value) {
                        // The first key contains the entire string.
                        if ($key !== 0) {
                            $vars[$varsNames[$key - 1]] = $value;
                        }
                    }

                    $route->setVars($vars);
                }
                return $route;
            }
            throw new \Exception('Aucune route ne correspond à l\'URL');
        }
    }
}
