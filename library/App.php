<?php

class App
{
    private static $instance;

    /** @var array */
    private $config;

    /** @var \Routes\Router */
    private $router;

    private function __construct()
    {
    }

    /**
     * @return App
     */
    public static function instance()
    {
        if (!App::$instance) {
            App::$instance = new App();
        }
        return App::$instance;
    }

    public function setup($config = [], $routes = [])
    {
        $this->config = $config;
        $this->router = \Routes\Router::instance();
        $this->router->setRoutes($routes);
    }

    public function run()
    {
        try {
            echo $this->router->handle($_SERVER['REQUEST_URI']);
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    public function getConfig($key = null)
    {
        if (!isset($key)) {
            return $this->config;
        }

        return $this->config[$key];
    }

    public function setConfig($key, $value)
    {
        $this->config[$key] = $value;
        return $this;
    }
}