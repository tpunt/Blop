<?php

namespace app\controllers;

use app\models\DataAccessLayer\UserMapper as UserMapper;

/**
 * Handles actions performed from a user's account.
 *
 * @package  Blop/app/controllers
 * @author   Thomas Punt
 * @license  MIT
 */
class AccountController
{
    /**
     * @var UserMapper|null     Holds the UserMapper object from the data access layer.
     */
    protected $userMapper = null;

    /**
     * Checks to see whether the user is logged in and assigns a UserMapper object to an instance variable.
     *
     * A check on whether the user is logged in is required to prevent access to the account page from
     * unregistered users. If they aren't logged in, then they will be relocated to the login page.
     *
     * @param UserMapper $userMapper  The UserMapper object from the data access layer.
     */
    public function __construct(UserMapper $userMapper)
    {
        if(!isset($_SESSION['user'])) { // Should I check to see if a user is logged in here?
            header('Location: /login');
            die;
        }

        $this->userMapper = $userMapper;
    }

    /**
     * Unsets the session data, destroy the session, and redirects the user to the index page.
     */
    public function logout()
    {
        unset($_SESSION);
        session_destroy();

        header('Location: /');
        die;
    }
}