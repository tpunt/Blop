<?php

namespace app\views;

use app\models\DataAccessLayer\WebPageContentMapper as WebPageContentMapper;
use app\models\DataAccessLayer\PostMapper as PostMapper;

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
     * @var Twig_Environment|null     $tplEngine          The instance of the template engine.
     * @var PostMapper|null           $postMapper         The instance of the Post data mapper.
     * @var WebPageContentMapper|null $pageContentMapper  The instance of the WebPageContent data mapper.
     */
    private $tplEngine = null,
            $postMapper = null,
            $pageContentMapper = null;

    /**
     * Assigns the arguments to instance variables to be used by the render() method.
     *
     * @param Twig_Environment     $tplEngine          The instance of the template engine.
     * @param PostMapper           $postMapper         the instance of the Post data mapper.
     * @param WebPageContentMapper $pageContentMapper  The instance of the WebPageContent data mapper.
     */
    public function __construct(\Twig_Environment $tplEngine, PostMapper $postMapper, WebPageContentMapper $pageContentMapper)
    {
        $this->tplEngine = $tplEngine;
        $this->postMapper = $postMapper;
        $this->pageContentMapper = $pageContentMapper;
    }

    /**
     * Contains all of the binding logic in order to render the threads.tpl file.
     *
     * @param array   $globalBindings  The information to be bound to every template.
     * @return string                  The rendered template.
     */
    public function render(array $globalBindings = [])
    {
        $tpl = $this->tplEngine->loadTemplate('post.tpl');

        $bindings = ['loggedIn' => (isset($_SESSION['user']) ? $_SESSION['user']['user_id'] : ''),
                     'pageTitle' => $this->pageContentMapper->getWebPage()->getWebPageTitle(),
                     'post' => $this->postMapper->getPostByID($_GET['action'])]; // don't use superglobal here

        return $tpl->render(array_merge($bindings, $globalBindings));
    }
}