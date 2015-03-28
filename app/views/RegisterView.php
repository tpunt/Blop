<?php

namespace app\views;

use app\models\DataAccessLayer\WebPageMapper;
use app\models\DataAccessLayer\UserMapper;

/**
 * This is the view containing the binding logic for the 'login' page (using the templates/login.tpl).
 *
 * @package  Blop/app/views
 * @author   Thomas Punt
 * @license  MIT
 */
class RegisterView
{
    /**
     * @var Twig_Environment|null $tplEngine   The instance of the template engine
     * @var string|               $route       The route taken by the application
     * @var WebPageMapper|null    $pageMapper     The instance of the WebPage data mapper
     * @var UserMapper|null       $userMapper  The instance of the User data mapper
     */
    private $tplEngine = null,
            $route = '',
            $pageMapper = null,
            $userMapper = null;

    /**
     * Assigns the arguments to instance variables to be used by the render() method.
     *
     * @param Twig_Environment $tplEngine   The instance of the template engine
     * @param string|          $route       The route taken by the application
     * @param WebPageMapper    $pageMapper     The instance of the WebPage data mapper
     * @param UserMapper       $userMapper  The instance of the User data mapper
     */
    public function __construct(\Twig_Environment $tplEngine, $route, WebPageMapper $pageMapper, UserMapper $userMapper)
    {
        $this->tplEngine = $tplEngine;
        $this->route = $route;
        $this->pageMapper = $pageMapper;
        $this->userMapper = $userMapper;
    }

    /**
     * Contains all of the binding logic in order to render the register.tpl file.
     *
     * @param array   $globalBindings  The information to be bound to every template.
     * @return string                  The rendered template.
     */
    public function render(array $globalBindings = [])
    {
        $route = strpos($this->route, '/') !== false ? explode('/', $this->route)[0] : $this->route;
        $webPage = $this->pageMapper->getPage($this->route);

        $tpl = $this->tplEngine->loadTemplate("{$route}.tpl");

        $bindings = ['regError' => $this->userMapper->getError(),
                     'pageTitle' => $webPage->getPageTitle(),
                     'pageDescription' => $webPage->getPageDescription(),
                     'pageKeywords' => $webPage->getPageKeywords(),
                     'loggedIn' => isset($_SESSION['user']) ? $_SESSION['user']['user_id'] : ''];

        return $tpl->render(array_merge($bindings, $globalBindings));
    }
}