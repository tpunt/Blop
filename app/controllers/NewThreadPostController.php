<?php

namespace app\controllers;

use app\models\DataAccessLayer\ThreadPostMapper as ThreadPostMapper;

/**
 * Handles thread creation (i.e. new blog post) actions.
 *
 * @package  Blop/app/controllers
 * @author   Thomas Punt
 * @license  MIT
 */
class NewThreadPostController
{
    /**
     * @var ThreadPostMapper|null  Holds the ThreadPostMapper object from the data access layer.
     */
    private $threadPostMapper = null;

    /**
     * Assigns a ThreadPostMapper domain object to be used by the controller's actions.
     *
     * @param ThreadPostMapper $threadPostMapper  The ThreadPost object from the data access layer.
     */
    public function __construct(ThreadPostMapper $threadPostMapper)
    {
        $this->threadPostMapper = $threadPostMapper;
    }

    /**
     * Passes the POST data to the ThreadPostMapper domain object to validate it and then save it.
     */
    public function create()
    {
        $this->threadPostMapper->addNewThread($_POST);
    }
}