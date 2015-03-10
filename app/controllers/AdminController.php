<?php

namespace app\controllers;

use app\models\DataAccessLayer\UserMapper;

/**
 * Handles actions performed from an admin's account.
 *
 * @package  Blop/app/controllers
 * @author   Thomas Punt
 * @license  MIT
 */
class AdminController extends AccountController
{
    /**
     * Invokes the parent constructor to ensure that the user is logged in.
     */
    public function __construct()
    {
        parent::__construct();
    }
}
