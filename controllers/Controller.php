<?php

namespace Controllers;

use Http\Request;
use Views\View;

class Controller
{
    /** @var View */
    protected $view;

    /** @var Request */
    protected $request;

    /** @var string */
    protected $action;

    public function __construct($template)
    {
        $this->request = new Request($_SERVER, $_POST);
        $this->view = new View($template);
        $this->view->setVar('title', '');
    }

    /**
     * @param mixed $action
     * @return string
     */
    public function executeAction($action, ...$params)
    {
        $this->view->setTemplate($action);
        $this->action = $action;
        $actionMethod = "{$this->action}Action";
        return $this->$actionMethod(...$params);
    }

    protected function redirect($location)
    {
        header("Location: $location");
    }
}
