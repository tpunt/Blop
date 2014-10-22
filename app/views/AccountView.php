<?php

namespace app\views;

use app\models\DataAccessLayer\UserMapper as UserMapper;

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
     * @return string  The rendered template.
     */
    public function render()
    {
        $tpl = $this->tplEngine->loadTemplate('account.tpl');

        $bindings = ['loggedIn' => (isset($_SESSION['user']) ? $_SESSION['user']['user_id'] : ''),
                     'baseURI' => 'http://lindseyspt.pro'];

        return $tpl->render($bindings);
    }
}