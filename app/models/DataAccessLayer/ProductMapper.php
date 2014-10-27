<?php

namespace app\models\DataAccessLayer;

use app\models\DomainModel\Product as Product;

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
     * @var PDO|null $pdo  The PDO object.
     */
    private $pdo = null;

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
     * Gets a group of products corresponding to the range of product ID's specified.
     *
     * @param int $from  The product ID to begin fetching products from.
     * @param int $to    The ending product ID to fetch the products to.
     * @return array     An array of Product objects containing thread information.
     */
    public function getProducts($from = 0, $to = 10) // pagination: 10 products/page | only specify a $from and make n/page configurable?
    {
        // validate $from/$to later

        $productsQuery = $this->pdo->query("SELECT product_id, product_name, stock_level, price, preview_photo
                                            FROM products WHERE product_id BETWEEN {$from} AND {$to}");

        // validate response of $productsQuery

        $products = [];

        while($p = $productsQuery->fetch(\PDO::FETCH_ASSOC))
            array_push($products, new Product($p['product_name'], $p['stock_level'], $p['price'], $p['preview_photo'], $p['product_id']));

        return $products;
    }

    public function getProductByID($pID)
    {
        //
    }
}