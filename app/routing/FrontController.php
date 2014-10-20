<?php

namespace app\routing;

use Dice\Dice as Dice;

/**
 * This is the entry point of the whole application. All requests are routed by the front controller
 * using information provided by the routes.php file.
 *
 * @package  Blop/app/routing
 * @author   Thomas Punt
 * @license  MIT
 */
class FrontController
{
    /**
     * Define the default route to take if no route or an invalid route is specified.
     */
    const DEFAULT_ROUTE = 'index';

    /**
     * @var View|null             $view       The view object being used.
     * @var Dice|null             $dic        The dependency injection container being used.
     * @var string|               $action     The controller action being invoked.
     * @var Twig_Environment|null $tplEngine  The templating engine being used.
     * @var string|               $route      The route being taken within the application.
     */
    private $view = null,
            $dic = null,
            $action = '',
            $tplEngine = null,
            $route = '';

    /**
     * Assigns the arguments to the fields, validates the route, and initiates the corresponding triad.
     *
     * @param  Dice             $dic        The dependency injection container to create object graphs.
     * @param  Trig_Environment $tplEngine  The templating engine to parse the tpl files in views/templates.
     * @param  Router           $router     The router to validate the route and get the corresponding triad.
     * @param  string           $route      The route being taken within the application.
     * @param  string           $action     The controller action being invoked.
     * @throws Exception                    Any exception being raised in the application.
     */
    public function __construct(Dice $dic, \Twig_Environment $tplEngine, Router $router, $route, $action)
    {
        $this->dic = $dic;
        $this->tplEngine = $tplEngine;
        $this->action = $action;

        if(!$router->isValidRoute($route))
            $this->route = self::DEFAULT_ROUTE;
        else
            $this->route = $route;

        $this->initiateTriad(...$this->normaliseNames(...$router->getTriad($this->route)));
    }

    /**
     * Make sure each component name is uses a fully qualified namespace so that it can be instantiated.
     *
     * @param  array  $models      The names of the models.
     * @param  string $view        The name of the view.
     * @param  string $controller  The name of the controller.
     * @return array               The fully qualified names of all parts of the triad.
     */
    private function normaliseNames(array $models, $view, $controller)
    {
        $m = [];

        if(!empty($models))
            foreach($models as $model)
                array_push($m, "\\app\\models\\DataAccessLayer\\{$model}"); // do I need to normalise the names for models?

        $v = "\\app\\views\\{$view}";
        $c = '';
        
        if(!empty($controller))
            $c = "\\app\\controllers\\{$controller}";

        return [$m, $v, $c];
    }

    /**
     * Instantiate each component of the triad and execute the controller action (if one was set).
     *
     * @param  array  $models      The names of the models.
     * @param  string $view        The name of the view.
     * @param  string $controller  The name of the controller.
     * @throws Exception           Any exception being raised in the application.
     */
    private function initiateTriad(array $models, $view, $controller)
    {
        $m = [];

        if(!empty($models))
            foreach($models as $model) {
                $model = $this->dic->create($model);

                if($model instanceof \app\models\DataAccessLayer\WebPageContentMapper)
                    $model->setPage($this->route);

                array_push($m, $model);
            }

        try {
            if(!empty($controller)) {
                $controller = new $controller(...$m);

                if(!empty($this->action) && method_exists($controller, $this->action))
                    $controller->{$this->action}();
            }
        }catch(\InvalidArgumentException $e) {
            header("Location: http://lindseyspt.pro/{$this->route}"); // don't hard-code the URI
            die;
        }

        $this->view = new $view($this->tplEngine, ...$m);
    }

    /**
     * Pass the rendered template from the view to the index page to be output.
     *
     * @return string  The rendered template.
     */
    public function render()
    {
        return $this->view->render();
    }
}