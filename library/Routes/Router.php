<?php

namespace Routes;

class Router
{
    /** @var Router */
    private static $instance;

    /** @var Route[] */
    private $routes = [];

    private function __construct()
    {
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
     * @param $routes
     */
    public function setRoutes($routes)
    {
        foreach ($routes as $r) {
            $this->addRoute(
                new Route(
                    $r['pattern'],
                    $r['controller'],
                    isset($r['action']) ? $r['action'] : null)
            );
        }
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
     * @throws \Throwable
     */
    public function handle($requestUri)
    {
        $parts = explode('/', explode('?', $requestUri)[0]);
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
            $view = new \Views\View('');
            $view->setTemplate('notFound');
            return $view->render();
        }
    }
}
