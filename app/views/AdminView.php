<?php

namespace app\views;

/**
 * This is the view containing the binding logic for the 'Admin' page (using the templates/admin.tpl).
 *
 * @package  Blop/app/views
 * @author   Thomas Punt
 * @license  MIT
 */
class AdminView
{
    /**
     * @var Twig_Environment|null  $tplEngine   The instance of the template engine.
     */
    private $tplEngine = null;

    /**
     * Assigns the arguments to instance variables to be used by the render() method.
     *
     * @param Twig_Environment  $tplEngine   The instance of the template engine.
     */
    public function __construct(\Twig_Environment $tplEngine)
    {
        $this->tplEngine = $tplEngine;
    }

    /**
     * Contains all of the binding logic in order to render the admin.tpl file.
     *
     * @param array   $globalBindings  The information to be bound to every template.
     * @return string                  The rendered template.
     */
    public function render(array $globalBindings = [])
    {
        $tpl = $this->tplEngine->loadTemplate('admin.tpl');

        $bindings = [
            'loggedIn' => $_SESSION['user']['user_id'],
            'pLevel' => $_SESSION['user']['pLevel']
        ];

        return $tpl->render(array_merge($bindings, $globalBindings));
    }
}
