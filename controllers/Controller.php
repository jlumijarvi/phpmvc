<?php

namespace Controllers;

class Controller
{
    /** @var \View */
    protected $view;

    /** @var \Request */
    protected $request;

    public function __construct($view)
    {
        $this->request = new \Request($_SERVER, $_POST);
        $this->view = new \View();
        $this->view->setTemplate($view);
    }
}
