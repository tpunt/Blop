<?php

namespace app\models\DataAccessLayer;

use app\models\DomainModel\Product as Product;
use app\models\DomainModel\Pagination as Pagination;

/**
 * This class handles products and their information.
 *
 * It both hydrates the Product domain model object from the DB to be sent to the corresponding
 * view, and persists the Product object to the database.
 *
 * @package  Blop/app/models/DataAccessLayer
 * @author   Thomas Punt
 * @license  MIT
 */
class ProductMapper
{
    /**
     * @var PDO|null        $pdo         The PDO object.
     * @var Pagination|null $pagination  The Pagination domain model object.
     */
    private $pdo = null,
            $pagination = null;

    /**
     * Assign the PDO object to an object instance.
     *
     * @param PDO $pdo  The PDO object.
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Creates and sets a new Pagination object to the pagination instance variable.
     *
     * @param int $pageNo  The page number for pagination.
     */
    public function newPagination($pageNo)
    {
        $elementCount = $this->pdo->query('SELECT COUNT(*) FROM products')->fetch(\PDO::FETCH_NUM)[0];

        $this->pagination = new Pagination('products', $elementCount, $pageNo);
    }

    /**
     * Gets a group of products corresponding to the range of product ID's specified.
     *
     * @return array     An array of Product objects containing thread information.
     */
    public function getProducts()
    {
        $products = [];

        if(!$this->pagination)
            $this->newPagination(1);

        if(!$this->pagination->getValidity())
            return $products;

        $from = $this->pagination->getFrom();
        $perPageNo = $this->pagination->getPerPageNo();

        $productsQuery = $this->pdo->query("SELECT product_id, product_name, stock_level, price, preview_photo
                                            FROM products LIMIT {$from}, {$perPageNo}");

        while($p = $productsQuery->fetch(\PDO::FETCH_ASSOC))
            array_push($products, new Product($p['product_name'], $p['stock_level'], $p['price'], $p['preview_photo'], $p['product_id']));

        return $products;
    }

    public function getProductByID($pID)
    {
        $pID = (int) $pID;

        $productQuery = $this->pdo->query("SELECT product_name, product_description, stock_level, price, preview_photo
                                           FROM products WHERE product_id = {$pID}");

        if(empty($productQuery))
            throw new \InvalidArgumentException('Invalid product ID.');

        $p = $productQuery->fetch(\PDO::FETCH_ASSOC);

        $product = new Product($p['product_name'], $p['stock_level'], $p['price'], $p['preview_photo'], $pID);
        $product->setProductDescription($p['product_description']);

        return $product;
    }
}