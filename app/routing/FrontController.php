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
     * @var string|               $get        The GET data for the page.
     */
    private $view = null,
            $dic = null,
            $tplEngine = null,
            $parentRoute = '',
            $childRoute = '',
            $action = '',
            $get = '';

    /**
     * Assigns the arguments to the fields, validates the route, and initiates the corresponding triad.
     *
     * @param  Dice             $dic        The dependency injection container to create object graphs.
     * @param  Twig_Environment $tplEngine  The templating engine to parse the tpl files in views/templates.
     * @param  Router           $router     The router to validate the route and get the corresponding triad.
     * @param  string           $route      The route being taken within the application.
     * @param  string           $action     The controller action being invoked.
     * @param  string           $get        The GET data for the web page.
     * @throws Exception                    Any exception being raised in the application.
     */
    public function __construct(Dice $dic, \Twig_Environment $tplEngine, Router $router, array $params)
    {
        $this->dic = $dic;
        $this->tplEngine = $tplEngine;

        if(empty($params[0]))
            $params[0] = self::DEFAULT_ROUTE;

        if(!$router->isValidParentRoute($params[0])) {
            header('Location: http://lindseyspt.pro'); // don't hardcode the URI
            die;
        }

        $triad = [];

        if($router->isParentRoute($params[0])) {
            if(empty($params[1]))
                $params[1] = self::DEFAULT_ROUTE;

            if(!$router->isValidChildRoute($params[0], $params[1])) {
                $params[2] = $params[1];
                $params[1] = self::DEFAULT_ROUTE;
            }

            $triad = $router->getTriad($params[0], $params[1]);
            list($this->parentRoute, $this->childRoute, $this->action, $this->get) = $params;
        }else{
            $triad = $router->getTriad($params[0]);
            list($this->parentRoute, $this->action, $this->get, $this->childRoute) = $params;
        }

        $this->initiateTriad(...$this->normaliseNames(...$triad));
    }

    /**
     * Make sure each component name uses a fully qualified namespace so that it can be instantiated.
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

                if($model instanceof \app\models\DataAccessLayer\WebPageContentMapper) {
                    $pageName = $this->parentRoute.(!empty($this->childRoute) ? "/{$this->childRoute}" : '');
                    $model->setPage($pageName);
                }

                array_push($m, $model);
            }

        try {
            if(!empty($controller)) {
                $controller = new $controller(...$m);

                if(!empty($this->action))
                    if(method_exists($controller, $this->action))
                        $controller->{$this->action}($this->get);
                    else
                        throw new \InvalidArgumentException('');
            }
        }catch(\InvalidArgumentException $e) {
            $pageName = $this->parentRoute.(!empty($this->childRoute) ? "/{$this->childRoute}" : '');
            header("Location: http://lindseyspt.pro/{$pageName}"); // don't hard-code the URI
            die;
        }

        $this->view = new $view($this->tplEngine, ...$m);
    }

    /**
     * Pass the rendered template from the view to the index page to be output.
     *
     * @param array   $globalBindings  The information to be bound to every template.
     * @return string                  The rendered template.
     */
    public function render(array $globalBindings = [])
    {
        return $this->view->render($globalBindings);
    }
}