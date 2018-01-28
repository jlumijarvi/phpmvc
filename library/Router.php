<?php

use Router\Route;

class Router
{
    /** @var Router */
    private static $instance;

    /** @var Route[] */
    private $routes = [];

    private function __construct()
    {
        $this->addRoute(new Route('', \Controllers\HomeController::class))
            ->addRoute(new Route('about', \Controllers\HomeController::class, 'about'));
    }

    /**
     * @return Router
     */
    public static function instance()
    {
        if (!Router::$instance) {
            Router::$instance = new Router();
        }
        return Router::$instance;
    }

    /**
     * @param Route $route
     * @return Router
     */
    public function addRoute($route)
    {
        $this->routes[] = $route;

        return $this;
    }

    /**
     * @return string
     */
    public function handle()
    {
        $parts = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($parts);

        $foundRoute = null;
        /** @var Route $route */
        foreach ($this->routes as $route) {
            $foundRoute = $route;
            $params = [];
            foreach ($parts as $part) {
                $matches = [];
                $pattern = $route->getPattern();
                if (preg_match("/^$pattern$/", $part, $matches)) {
                    foreach ($matches as $match) {
                        $params[] = $match;
                    }
                } else {
                    $foundRoute = null;
                    break;
                }
            }
            if ($foundRoute) {
                break;
            }
        }
        if ($foundRoute) {
            return $foundRoute->dispatch();
        } else {
            $notFound = new \Controllers\HomeController();
            return $notFound->notFoundAction();
        }
    }
}