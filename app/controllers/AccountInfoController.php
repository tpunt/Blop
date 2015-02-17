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
class AccountInfoController extends AccountController
{
    /**
     * Invokes and passes the UserMapper object to its parent's controller, which in turn checks to
     * see whether the user is logged in and assigns the UserMapper object to its instance variable.
     *
     * A check on whether the user is logged in is required to prevent access to the account page from
     * unregistered users. If they aren't logged in, then they will be relocated to the login page.
     *
     * @param UserMapper $userMapper  The UserMapper object from the data access layer.
     */
    public function __construct(UserMapper $userMapper)
    {
        parent::__construct($userMapper);
    }

    /**
     *
     */
    public function updateGeneralInfo()
    {
        $this->userMapper->modifyUserGeneralInfo($_POST, $_SESSION['user']['user_id']); // don't directly use $_POST
    }

    public function updateSensitiveInfo()
    {
        $this->userMapper->modifyUserSensitiveInfo($_POST, $_SESSION['user']['user_id']); // don't directly use $_POST
    }
}