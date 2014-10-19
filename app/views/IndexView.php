<?php

namespace app\views;

use app\models\DataAccessLayer\WebPageContentMapper as WebPageContentMapper;

class IndexView
{
    private $tplEngine = null;
    private $pageContentMapper = null;

    public function __construct(\Twig_Environment $tplEngine, WebPageContentMapper $pageContentMapper) // have a generic model for all tpls? binding logic problems with this?
    {
        $this->tplEngine = $tplEngine;
        $this->pageContentMapper = $pageContentMapper;
    }

    public function render()
    {
        $tpl = $this->tplEngine->loadTemplate('index.tpl');

        $bindings = ['loggedIn' => (isset($_SESSION['user']) ? $_SESSION['user']['user_id'] : ''),
                     'baseURI' => 'http://lindseyspt.pro',
                     'pageTitle' => $this->pageContentMapper->getWebPage()->getWebPageTitle()];

        return $tpl->render($bindings);
    }
}