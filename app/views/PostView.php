<?php

namespace app\views;

use app\models\DataAccessLayer\WebPageMapper;
use app\models\DataAccessLayer\PostMapper;

/**
 * This is the view containing the binding logic for an indivual post page (using the templates/post.tpl).
 *
 * @package  Blop/app/views
 * @author   Thomas Punt
 * @license  MIT
 */
class PostView
{
    /**
     * @var Twig_Environment|null $tplEngine   The instance of the template engine
     * @var string|               $route       The route taken by the application
     * @var PostMapper|null       $postMapper  The instance of the Post data mapper
     * @var WebPageMapper|null    $pageMapper  The instance of the WebPage data mapper
     */
    private $tplEngine = null,
            $route = '',
            $postMapper = null,
            $pageMapper = null;

    /**
     * Assigns the arguments to instance variables to be used by the render() method.
     *
     * @param Twig_Environment $tplEngine   The instance of the template engine
     * @param string|          $route       The route taken by the application
     * @param PostMapper       $postMapper  The instance of the Post data mapper
     * @param WebPageMapper    $pageMapper  The instance of the WebPage data mapper
     */
    public function __construct(\Twig_Environment $tplEngine, $route, PostMapper $postMapper, WebPageMapper $pageMapper)
    {
        $this->tplEngine = $tplEngine;
        $this->route = $route;
        $this->postMapper = $postMapper;
        $this->pageMapper = $pageMapper;
    }

    /**
     * Contains all of the binding logic in order to render the post.tpl file.
     *
     * @param array   $globalBindings  The information to be bound to every template
     * @return string                  The rendered template
     */
    public function render(array $globalBindings = [])
    {
        $route = strpos($this->route, '/') !== false ? explode('/', $this->route)[0] : $this->route;
        $webPage = $this->pageMapper->getPage($this->route);

        $tpl = $this->tplEngine->loadTemplate("{$route}.tpl");

        $bindings = ['loggedIn' => (isset($_SESSION['user']) ? $_SESSION['user']['user_id'] : ''),
                     'pageTitle' => $webPage->getPageTitle(),
                     'post' => $this->postMapper->getPostByID($_GET['param2'])]; // don't use superglobal here

        return $tpl->render(array_merge($bindings, $globalBindings));
    }
}
