<?php

namespace Controllers;

use Models\User;
use Views\Script;

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct('users');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function indexAction()
    {
        if ($this->request->method === 'POST') {
            /** @var User $user */
            $user = User::findFirst(2);
            $user->name = $this->request->post->name;
            $user->update();
        }

        /** @var User[] $users */
        $users = User::find();
        $this->view->setVar('title', 'Users');
        $this->view->setVar('users', $users);
        $this->view->addScript(new Script('js/users.js'));

        return $this->view->render();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function showAction($id)
    {
        $this->view->setVar('title', 'Users');
        $this->view->setVar('id', $id);
        return $this->view->render();
    }
}