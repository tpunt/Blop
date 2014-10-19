<?php

namespace app\views;

use app\models\DataAccessLayer\UserMapper as UserMapper;

class RegisterView
{
    private $tplEngine = null;
    private $userMapper = null;

    public function __construct(\Twig_Environment $tplEngine, UserMapper $userMapper)
    {
        $this->tplEngine = $tplEngine;
        $this->userMapper = $userMapper;
    }

    public function render()
    {
        $tpl = $this->tplEngine->loadTemplate('register.tpl');

        $bindings = ['regError' => $this->userMapper->getError(),
                     'loggedIn' => (isset($_SESSION['user']) ? $_SESSION['user']['user_id'] : ''),
                     'baseURI' => 'http://lindseyspt.pro'];

        return $tpl->render($bindings);
    }
}