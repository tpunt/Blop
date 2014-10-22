<?php

namespace app\views;

use app\models\DataAccessLayer\WebPageContentMapper as WebPageContentMapper;

/**
 * This is the view containing the binding logic for the 'about me' page (using the templates/aboutme.tpl).
 *
 * @package  Blop/app/views
 * @author   Thomas Punt
 * @license  MIT
 */
class AboutMeView
{
    /**
     * @var Twig_Environment|null     $tplEngine          The instance of the template engine.
     * @var WebPageContentMapper|null $pageContentMapper  The instance of the WebPageContent data mapper.
     */
    private $tplEngine = null,
            $pageContentMapper = null;

    /**
     * Assigns the arguments to instance variables to be used by the render() method.
     *
     * @param Twig_Environment     $tplEngine          The instance of the template engine.
     * @param WebPageContentMapper $pageContentMapper  The instance of the WebPageContent data mapper.
     */
    public function __construct(\Twig_Environment $tplEngine, WebPageContentMapper $pageContentMapper)
    {
        $this->tplEngine = $tplEngine;
        $this->pageContentMapper = $pageContentMapper;
    }

    /**
     * Contains all of the binding logic in order to render the aboutme.tpl file.
     *
     * @return string  The rendered template.
     */
    public function render()
    {
        $tpl = $this->tplEngine->loadTemplate('aboutme.tpl');

        $bindings = ['loggedIn' => (isset($_SESSION['user']) ? $_SESSION['user']['user_id'] : ''),
                     'baseURI' => 'http://lindseyspt.pro',
                     'pageTitle' => $this->pageContentMapper->getWebPage()->getWebPageTitle()];

        return $tpl->render($bindings);
    }
}