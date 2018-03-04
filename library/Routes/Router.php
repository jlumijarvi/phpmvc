<?php

namespace Routes;

class Router
{
    /** @var Router */
    private static $instance;

    /** @var Route[] */
    private $routes = [];

    /** @var Route */
    private $current;

    private function __construct()
    {
    }

    /**
     * @return Router
     */
    public static function instance()
    {
        if (!static::$instance) {
            static::$instance = new Router();
        }
        return static::$instance;
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
                    isset($r['action']) ? $r['action'] : null,
                    isset($r['name']) ? $r['name'] : null
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

        $this->current = null;
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
                $this->current = $route;
                break;
            }
        }
        if ($this->current) {
            return $this->current->dispatch(...$params);
        } else {
            $this->current = new Route(null, null, null);
            $view = new \Views\View();
            $view->setTemplate('notFound');
            return $view->render();
        }
    }

    public function getCurrent()
    {
        return $this->current;
    }
}
