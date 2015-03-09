<?php

namespace app\controllers;

use app\models\DataAccessLayer\UserMapper;

/**
 * Handles login actions.
 *
 * @package  Blop/app/controllers
 * @author   Thomas Punt
 * @license  MIT
 */
class LoginController
{
    /**
     * @var UserMapper|null     Holds the UserMapper object from the data access layer.
     */
    private $userMapper = null;

    /**
     * Checks to see whether the user is logged in - if they are, then relocate them to their account page.
     *
     * @param UserMapper $userMapper  The UserMapper object from the data access layer.
     */
    public function __construct(UserMapper $userMapper)
    {
        if(isset($_SESSION['user'])) { // Should I check to see if a user is logged in here?
            header('Location: /account');
            die;
        }

        $this->userMapper = $userMapper;
    }

    /**
     * Passes the POST data to the UserMapper domain object to validate it.
     */
    public function validateLogin()
    {
        $this->userMapper->validateUserLogin($_POST); // should I use a global directly here?
    }
}