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
     * @param  string $routesFile        The file containing information about all the valid routes.
     * @throws InvalidArgumentException  Thrown if the file either doesn't exist or isn't readable.
     */
    public function __construct($routesFile)
    {
        if(!is_readable($routesFile))
            throw new \InvalidArgumentException('The routes.php file could not be read.');

        $this->routes = require $routesFile;
    }

    /**
     * Checks to see if the super route has a sub route.
     *
     * @param  string $routeName  The name of the super route.
     * @return bool               Whether a sub route exists or not.
     */
    public function hasSubRoute($superRoute)
    {
        if(isset($this->routes[$superRoute][0]))
            return false;

        return true;
    }

    /**
     * Checks to ensure the super route name is valid.
     *
     * @param  string $superRoute  The name of the super route.
     * @return bool                Whether the route exists or not.
     */
    public function isValidSuperRoute($superRoute)
    {
        return isset($this->routes[$superRoute]);
    }

    /**
     * Checks to ensure the sub route name is valid.
     *
     * @param  string $superRoute  The name of the sub route.
     * @return bool                Whether the route exists or not.
     */
    public function isValidSubRoute($superRoute, $subRoute)
    {
        return isset($this->routes[$superRoute][$subRoute]);
    }

    /**
     * Gets the route's corresponding triad of components.
     *
     * @param  string $superRoute  The name of the super route.
     * @param  string $superRoute  The name of the sub route if one is present.
     * @return array               The class names of the triad of components.
     */
    public function getTriad($superRoute, $subRoute = '')
    {
        if(empty($subRoute))
            return $this->routes[$superRoute];

        return $this->routes[$superRoute][$subRoute];
    }
}