<?php

namespace app\controllers;

use app\models\DataAccessLayer\ProductMapper;

/**
 * Handles the viewing of products.
 *
 * @package  Blop/app/controllers
 * @author   Thomas Punt
 * @license  MIT
 */
class ProductsController // product(S)? Difference between overview page of products VS single page view of a product
{
    /**
     * @var ProductMapper|null            Holds the ProductMapper object from the data access layer.
     */
    private $productMapper = null;

    /**
     * Sets the Product domain object mapper.
     *
     * This method purposefully chooses to ignore the second argument being passed to it
     * (the WebPageContentMapper object) because the controller does not need such an object.
     *
     * @param ProductMapper $productMapper  The ProductMapper object from the data access layer.
     */
    public function __construct(ProductMapper $productMapper)
    {
        $this->productMapper = $productMapper;
    }

    /**
     * Passes the GET data to the ProductMapper domain object to validate it.
     */
    public function page($pageNo)
    {
        $this->productMapper->newPagination($pageNo);
    }
}