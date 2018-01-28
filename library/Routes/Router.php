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
     * @param $routeConfigs
     */
    public function setRoutes($routeConfigs)
    {
        foreach ($routeConfigs as $r) {
            $this->addRoute(
                new Route(
                    $r['pattern'],
                    $r['controller'],
                    isset($r['action']) ? $r['action'] : null
                )
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
    public function route($requestUri)
    {
        $parts = explode('/', explode('?', $requestUri)[0]);
        array_shift($parts);
        $url = implode('/', $parts);

        $foundRoute = null;
        $params = [];
        /** @var Route $route */
        foreach ($this->routes as $route) {
            $matches = [];
            $pattern = "/^{$route->getPattern()}$/";
            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);
                foreach ($matches as $match) {
                    $params[] = $match;
                }
                $foundRoute = $route;
                break;
            }
        }
        if ($foundRoute) {
            return $foundRoute->dispatch(...$params);
        } else {
            $view = new \Views\View();
            $view->setTemplate('notFound');
            return $view->render();
        }
    }
}
