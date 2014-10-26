<?php

namespace app\views;

use app\models\DataAccessLayer\UserMapper as UserMapper;

/**
 * This is the view containing the binding logic for the 'login' page (using the templates/login.tpl).
 *
 * @package  Blop/app/views
 * @author   Thomas Punt
 * @license  MIT
 */
class LoginView
{
    /**
     * @var Twig_Environment|null  $tplEngine   The instance of the template engine.
     * @var UserMapper|null        $userMapper  The instance of the User data mapper.
     */
    private $tplEngine = null,
            $userMapper = null;

    /**
     * Assigns the arguments to instance variables to be used by the render() method.
     *
     * @param Twig_Environment  $tplEngine   The instance of the template engine.
     * @param UserMapper        $userMapper  The instance of the User data mapper.
     */
    public function __construct(\Twig_Environment $tplEngine, UserMapper $userMapper)
    {
        $this->tplEngine = $tplEngine;
        $this->userMapper = $userMapper;
    }

    /**
     * Contains all of the binding logic in order to render the login.tpl file.
     *
     * @param array   $globalBindings  The information to be bound to every template.
     * @return string                  The rendered template.
     */
    public function render(array $globalBindings = [])
    {
        $tpl = $this->tplEngine->loadTemplate('login.tpl');

        $bindings = ['loginError' => $this->userMapper->getError(),
                     'loggedIn' => (isset($_SESSION['user']) ? $_SESSION['user']['user_id'] : '')];

        return $tpl->render(array_merge($bindings, $globalBindings));
    }
}