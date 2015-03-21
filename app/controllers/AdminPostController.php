<?php

namespace app\controllers;

use app\models\DataAccessLayer\PostMapper;

/**
 * Handles actions performed from an admin's account regarding the content of the website.
 *
 * @package  Blop/app/controllers
 * @author   Thomas Punt
 * @license  MIT
 */
class AdminPostController extends AdminController
{
    /**
     * @var PostMapper|null  Used to edit, update, or delete a blog post
     */
    private $postMapper = null;

    /**
     * Invokes the parent contstructor to perform a check to see whether the user is logged in.
     * If they aren't, then they will be relocated to the login page.
     *
     * @param PostMapper $postMapper  Used to edit, update, or delete a blog post
     */
    public function __construct(PostMapper $postMapper)
    {
        parent::__construct();

        $this->postMapper = $postMapper;
    }

    /**
     * Used to update the content for the index page.
     */
    public function edit()
    {
        $this->postMapper->modifyPost($_POST, isset($_GET['postID']) ? $_GET['postID'] : '');
    }

    public function create()
    {
        $this->postMapper->newPost($_POST, $_SESSION['user']['user_id']);
    }

    public function delete()
    {
        $this->postMapper->deletePost(isset($_GET['postID']) ? $_GET['postID'] : '');
    }
}
