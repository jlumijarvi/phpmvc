<?php

namespace Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct('home');
    }

    public function indexAction()
    {
        if ($this->request->method === 'POST') {
            $this->view->setVar('search', $this->request->post->search);
            $this->view->setTemplate('search');
            return $this->view->render();
        } else {
            $this->view->setVar('title', 'Home');
            return $this->view->render();
        }
    }

    public function aboutAction()
    {
        $this->view->setVar('title', 'About');
        $this->view->setTemplate('about');
        return $this->view->render();
    }

    public function notFoundAction()
    {
        $this->view->setTemplate('notFound');
        return $this->view->render();
    }

    protected function redirect($location)
    {
        header('Location: ' . $location);
    }
}