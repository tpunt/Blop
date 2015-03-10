<?php

namespace app\controllers;

use app\models\DataAccessLayer\WebPageContentMapper;

/**
 * Handles actions performed from an admin's account regarding the content of the website.
 *
 * @package  Blop/app/controllers
 * @author   Thomas Punt
 * @license  MIT
 */
class AdminSiteInfoController extends AdminController
{
    /**
     * @var WebPageContentMapper|null  Used to manipulate the content of the website.
     */
    private $webPageContentMapper = null;

    /**
     * Invokes the parent contstructor to perform a check to see whether the user is logged in.
     * If they aren't, then they will be relocated to the login page.
     *
     * @param WebPageContentMapper $webPageContentMapper  Used to alter the content of the website.
     */
    public function __construct(WebPageContentMapper $webPageContentMapper)
    {
        parent::__construct();

        $this->webPageContentMapper = $webPageContentMapper;
    }

    /**
     * Used to update the content for the index page.
     */
    public function updateIndexPageContent()
    {
        $this->webPageContentMapper->modifyWebPageContent('index', $_POST)
    }
}
