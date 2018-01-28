<?php

namespace Routes;

use Controllers\Controller;

class Route
{
    /** @var string */
    private $pattern;
    /** @var string */
    private $controller;
    /** @var string */
    private $action;

    public function __construct($pattern, $controller, $action = 'index')
    {
        $this->pattern = $pattern;
        $this->controller = $controller;
        $this->action = $action ? $action : 'index';
    }

    public function dispatch(...$params)
    {
        /** @var Controller $ctrl */
        $ctrl = new $this->controller();
        return $ctrl->executeAction($this->action, $params);
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}