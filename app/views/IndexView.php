<?php

namespace app\views;

use app\models\DataAccessLayer\WebPageMapper;

/**
 * This is the view containing the binding logic for the 'Index' page (using the templates/index.tpl).
 *
 * @package  Blop/app/views
 * @author   Thomas Punt
 * @license  MIT
 */
class IndexView
{
    /**
     * @var Twig_Environment|null $tplEngine   The instance of the template engine
     * @var string|               $route       The route taken by the application
     * @var WebPageMapper|null    $pageMapper  The instance of the WebPage data mapper
     */
    private $tplEngine = null,
            $route = '',
            $pageMapper = null;

    /**
     * Assigns the arguments to instance variables to be used by the render() method.
     *
     * @param Twig_Environment $tplEngine  The instance of the template engine
     * @param string|          $route      The route taken by the application
     * @param WebPageMapper $pageMapper    The instance of the WebPage data mapper
     */
    public function __construct(\Twig_Environment $tplEngine, $route, WebPageMapper $pageMapper)
    {
        $this->tplEngine = $tplEngine;
        $this->route = $route;
        $this->pageMapper = $pageMapper;
    }

    /**
     * Contains all of the binding logic in order to render the index.tpl file.
     *
     * @param array   $globalBindings  The information to be bound to every template.
     * @return string                  The rendered template.
     */
    public function render(array $globalBindings = [])
    {
        $route = strpos($this->route, '/') !== false ? explode('/', $this->route)[0] : $this->route;
        $webPage = $this->pageMapper->getPage($this->route);

        $tpl = $this->tplEngine->loadTemplate("{$route}.tpl");

        $bindings = ['loggedIn' => (isset($_SESSION['user']) ? $_SESSION['user']['user_id'] : ''),
                     'pageTitle' => $webPage->getPageTitle(),
                     'pageContent' => $webPage->getPageContent()];

        return $tpl->render(array_merge($bindings, $globalBindings));
    }
}
