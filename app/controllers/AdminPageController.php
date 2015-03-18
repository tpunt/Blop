<?php

namespace app\controllers;

use app\models\DataAccessLayer\WebPageMapper;

/**
 * Handles actions performed from an admin's account regarding the content of the website.
 *
 * @package  Blop/app/controllers
 * @author   Thomas Punt
 * @license  MIT
 */
class AdminPageController extends AdminController
{
    /**
     * @var WebPageContentMapper|null  Used to manipulate the content of the website.
     */
    private $webPageMapper = null;

    /**
     * Invokes the parent contstructor to perform a check to see whether the user is logged in.
     * If they aren't, then they will be relocated to the login page.
     *
     * @param WebPageContentMapper $webPageContentMapper  Used to alter the content of the website.
     */
    public function __construct(WebPageMapper $webPageMapper)
    {
        parent::__construct();

        $this->webPageMapper = $webPageMapper;
    }

    /**
     * Used to update the content for the index page.
     */
    public function edit()
    {
        $this->webPageMapper->modifyWebPage(isset($_GET['page']) ? $_GET['page'] : '', $_POST);
    }
}
