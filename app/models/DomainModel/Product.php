<?php

namespace app\models\DomainModel;

/**
 * This class encapsulates the business logic for a product
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class Product
{
    /**
     * @var int|0     $productID          The auto-generated product ID.
     * @var string|   $productName        The product name.
     * @var string|   $productDescr       A description of the product.
     * @var int|0     $productStockLevel  Current stock level of the product.
     * @var float|0.0 $productPrice       The price of the product.
     * @var int|0     $productViews       The number of views a product has had.
     * @var string|   $productPrevPhoto   The preview photo of the product show on the products overview page.
     */
    private $productID = 0,
            $productName = '',
            $productDescr = '',
            $productStockLevel = 0,
            $productPrice = 0.0,
            $productViews = 0,
            $productPrevPhoto = '';

    /**
     * Validate and set each of the properties of a product.
     *
     * @param  string $pName             The product name.
     * @param  int    $pStockLevel       Current stock level of the product.
     * @param  float  $pPrice            The price of the product.
     * @param  string $pPrevPhoto        The preview photo of the product show on the products overview page.
     * @param  string $pID               The auto-generated product ID.
     * @throws InvalidArgumentException  Thrown if any fields contain invalid data.
     */
    public function __construct($pName, $pStockLevel, $pPrice, $pPrevPhoto, $pID = 0)
    {
        $this->setProductName($pName);
        $this->setProductStockLevel($pStockLevel);
        $this->setProductPrice($pPrice);
        $this->setProductPrevPhoto($pPrevPhoto);

        if($pID !== 0)
            $this->setProductID($pID);
    }

    /**
     * Validates and sets the product id.
     *
     * @param  int $pID                  The auto-generated product ID.
     * @throws InvalidArgumentException  Thrown if the product ID is less than 1.
     */
    public function setProductID($pID)
    {
        if($pID < 1) // required? Esp. if the pID is coming from the DB only
            throw new \InvalidArgumentException('Invalid product ID.');

        $this->productID = $pID;
    }

    /**
     * Validates and sets the product name.
     *
     * @param  int $pName                The product name.
     * @throws InvalidArgumentException  Thrown if the product name is too short or too long.
     */
    private function setProductName($pName)
    {
        $pNameLength = strlen($pName);

        if($pNameLength < 3 || $pNameLength > 70)
            throw new \InvalidArgumentException('Invalid product name.');

        $this->productName = $pName;
    }

    /**
     * Validates and sets the product description.
     *
     * @param  int $pDescr               A description of the product.
     * @throws InvalidArgumentException  Thrown if the product description is too short or too long.
     */
    private function setProductDescription($pDescr)
    {
        $pDescrLength = strlen($pDescr);

        if($pDescrLength < 20 || $pDescrLength > 65535)
            throw new \InvalidArgumentException('Invalid product description.');

        $this->productDescr = $pDescr;
    }

    /**
     * Validates and sets the product stock level.
     *
     * @param  int $pStockLevel          Current stock level of the product.
     * @throws InvalidArgumentException  Thrown if the product stock level is less than 0.
     */
    private function setProductStockLevel($pStockLevel)
    {
        if($pStockLevel < 0) // required? Esp. if the pID is coming from the DB only
            throw new \InvalidArgumentException('Invalid product stock level.');

        $this->productStockLevel = $pStockLevel;
    }

    /**
     * Validates and sets the product price.
     *
     * @param  int $pPrice               The price of the product.
     * @throws InvalidArgumentException  Thrown if the product price is less than 0.
     */
    private function setProductPrice($pPrice)
    {
        if($pPrice < 0)
            throw new \InvalidArgumentException('Inalid product price.');

        $this->productPrice = $pPrice;
    }

    /**
     * Sets the product preview photo.
     *
     * @param  int $pPrevPhoto           The preview photo of the product show on the products overview page.
     */
    private function setProductPrevPhoto($pPrevPhoto)
    {
        // validate link here?

        $this->productPrevPhoto = $pPrevPhoto;
    }

    use MagicGetter;
}