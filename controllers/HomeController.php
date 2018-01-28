<?php

namespace Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct('home');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function indexAction()
    {
        if (!empty($this->request->query->search)) {
            $this->view->setVar('search', $this->request->query->search);
            $this->view->setTemplate('search');
        }
        $this->view->setVar('title', 'Home');
        return $this->view->render();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function authorizedAction()
    {
        return $this->redirect('/signin');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function aboutAction()
    {
        $this->view->setVar('title', 'About');
        return $this->view->render();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function signinAction()
    {
        $this->view->setLayout(null);
        $this->view->setVar('title', 'Sign-in');
        return $this->view->render();
    }

    protected function redirect($location)
    {
        header('Location: ' . $location);
    }
}