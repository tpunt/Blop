<?php

namespace app\routing;

use Dice\Dice as Dice;

/**
 * This is the entry point of the whole application. All requests are routed by the front controller
 * using the routes.php file.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class FrontController
{
    const DEFAULT_ROUTE = 'index';
    private $view = null;
    private $dic = null;
    private $action = '';
    private $tplEngine = null;
    private $route = '';

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

    public function render()
    {
        return $this->view->render();
    }
}