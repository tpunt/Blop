<?php

namespace app\controllers;

use app\models\DataAccessLayer\PostMapper;

/**
 * Handles the viewing of posts.
 *
 * @package  Blop/app/controllers
 * @author   Thomas Punt
 * @license  MIT
 */
class PostsController
{
    /**
     * @var PostMapper|null  Holds the ProductMapper object from the data access layer.
     */
    private $postMapper = null;

    /**
     * Sets the Product domain object mapper.
     *
     * This method purposefully chooses to ignore the second argument being passed to it
     * (the WebPageContentMapper object) because the controller does not need such an object.
     *
     * @param ProductMapper $productMapper  The ProductMapper object from the data access layer.
     */
    public function __construct(PostMapper $postMapper)
    {
        $this->postMapper = $postMapper;
    }

    /**
     * Passes the GET data to the PostMapper domain object to validate it.
     */
    public function page($pageNo)
    {
        $this->postMapper->newPagination($pageNo);
    }
}