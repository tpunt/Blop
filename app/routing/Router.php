<?php

namespace app\routing;

class Router
{
    private $routes = [];

    public function __construct($routesFile)
    {
        // skip file validations for now
        $this->routes = require $routesFile;
    }

    public function isValidRoute($key)
    {
        return isset($this->routes[$key]);
    }

    public function getTriad($key)
    {
        return $this->routes[$key];
    }
}