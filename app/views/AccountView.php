<?php

namespace app\views;

use app\models\DataAccessLayer\UserMapper;

/**
 * This is the view containing the binding logic for the 'Account' page (using the templates/account.tpl).
 *
 * @package  Blop/app/views
 * @author   Thomas Punt
 * @license  MIT
 */
class AccountView
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
     * Contains all of the binding logic in order to render the account.tpl file.
     *
     * @param array   $globalBindings  The information to be bound to every template.
     * @return string                  The rendered template.
     */
    public function render(array $globalBindings = [])
    {
        $tpl = $this->tplEngine->loadTemplate('account.tpl');
        $user = $this->userMapper->getUser($_SESSION['user']['user_id'], ['forename', 'surname', 'email']);

        $bindings = [
            'loggedIn' => $_SESSION['user']['user_id'],
            'pLevel' => $_SESSION['user']['pLevel'],
            'user' => $user,
            "{$this->userMapper->getErrorTag()}Error" => $this->userMapper->getError()
        ];

        return $tpl->render(array_merge($bindings, $globalBindings));
    }
}
