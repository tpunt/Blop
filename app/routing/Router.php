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

    /**
     * Checks to ensure the route name is valid.
     *
     * @param  string $routeName  The name of the route.
     * @return bool               Whether the route exists or not.
     */
    public function isValidRoute($routeName)
    {
        return isset($this->routes[$routeName]);
    }

    /**
     * Gets the route's corresponding triad of components.
     *
     * @param  string $routeName  The name of the route.
     * @return array              The class names of the triad of components.
     */
    public function getTriad($routeName)
    {
        return $this->routes[$routeName];
    }
}