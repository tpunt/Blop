<?php

namespace app\controllers;

use app\models\DataAccessLayer\UserMapper;

/**
 * Handles registration actions.
 *
 * @package  Blop/app/controllers
 * @author   Thomas Punt
 * @license  MIT
 */
class RegisterController
{
    /**
     * @var UserMapper|null     Holds the UserMapper object from the data access layer
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
     * Passes the POST data to the UserMapper domain object to validate it and then save it.
     */
    public function validateRegistration()
    {
        $this->userMapper->validateUserRegistration($_POST); // should I use a global directly here?
    }
}