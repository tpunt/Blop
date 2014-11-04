<?php

namespace app\routing;

/**
 * This class handles everything to do with routing in the application.
 * 
 * It holds every possible route, validates a route, and returns the corresponding triad
 * for a specified route.
 *
 * @package  Blop/app/routing
 * @author   Thomas Punt
 * @license  MIT
 */
class Router
{
    /**
     * @var array|  Every valid route in the application.
     */
    private $routes = [];

    /**
     * Ensures the routes.php file exists and can be read, and then populates the $routes
     * instance variable.
     *
     * @param string $routesFile  The file containing information about all the valid routes.
     */
    public function __construct($routesFile)
    {
        if(!is_readable($routesFile))
            throw new \InvalidArgumentException('The routes.php file could not be read.');

        $this->routes = require $routesFile;
    }

    public function isParentRoute($routeName)
    {
        if(isset($this->routes[$routeName][0]))
            return false;

        return true;
    }

    /**
     * Checks to ensure the route name is valid.
     *
     * @param  string $routeName  The name of the route.
     * @return bool               Whether the route exists or not.
     */
    public function isValidParentRoute($parentRoute)
    {
        return isset($this->routes[$parentRoute]);
    }

    public function isValidChildRoute($parentRoute, $childRoute)
    {
        return isset($this->routes[$parentRoute][$childRoute]);
    }

    /**
     * Gets the route's corresponding triad of components.
     *
     * @param  string $routeName  The name of the route.
     * @return array              The class names of the triad of components.
     */
    public function getTriad($parentRoute, $childRoute = '')
    {
        if(empty($childRoute))
            return $this->routes[$parentRoute];

        return $this->routes[$parentRoute][$childRoute];
    }
}