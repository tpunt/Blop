<?php

namespace app\views;

use app\models\DataAccessLayer\WebPageContentMapper as WebPageContentMapper;
use app\models\DataAccessLayer\ProductMapper as ProductMapper;

/**
 * This is the view containing the binding logic for the 'products' page (using the templates/products.tpl).
 *
 * @package  Blop/app/views
 * @author   Thomas Punt
 * @license  MIT
 */
class ProductsView
{
    /**
     * @var Twig_Environment|null     $tplEngine          The instance of the template engine.
     * @var WebPageContentMapper|null $pageContentMapper  The instance of the WebPageContent data mapper.
     * @var ProductMapper|null        $productMapper      The instance of the Product data mapper.
     */
    private $tplEngine = null,
            $pageContentMapper = null,
            $productMapper = null;

    /**
     * Assigns the arguments to instance variables to be used by the render() method.
     *
     * @param Twig_Environment     $tplEngine          The instance of the template engine.
     * @param ProductMapper        $productMapper      The instance of the Product data mapper.
     * @param WebPageContentMapper $pageContentMapper  The instance of the WebPageContent data mapper.
     */
    public function __construct(\Twig_Environment $tplEngine, ProductMapper $productMapper, WebPageContentMapper $pageContentMapper)
    {
        $this->tplEngine = $tplEngine;
        $this->pageContentMapper = $pageContentMapper;
        $this->productMapper = $productMapper;
    }

    /**
     * Contains all of the binding logic in order to render the products.tpl file.
     *
     * @param array   $globalBindings  The information to be bound to every template.
     * @return string                  The rendered template.
     */
    public function render(array $globalBindings = [])
    {
        $tpl = $this->tplEngine->loadTemplate('products.tpl');

        $bindings = ['loggedIn' => (isset($_SESSION['user']) ? $_SESSION['user']['user_id'] : ''),
                     'pageTitle' => $this->pageContentMapper->getWebPage()->getWebPageTitle(),
                     'products' => $this->productMapper->getProducts()];

        return $tpl->render(array_merge($bindings, $globalBindings));
    }
}