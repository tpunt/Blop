<?php

use app\routing\FrontController as FrontController;
use app\routing\Router as Router;
use app\models\DataAccessLayer\RedisSessionHandler as RedisSessionHandler;

// autoloaders
require __DIR__.'/autoloader.php'; // try to get rid of this and just use Composer's autoloader
$loader = require __DIR__.'/vendor/autoload.php';

// configurations
$dbconfig = require __DIR__.'/config/dbconfig.php';
require __DIR__.'/config/dicconfig.php';
$dic = new Dice\Dice;
configureDICE($dic, ['dbconfig' => $dbconfig]);
$globalBindings = require __DIR__.'/config/genconfig.php';

$redis = new Redis();
$redis->connect($dbconfig['redis']['host'], $dbconfig['redis']['port'], $dbconfig['redis']['timeout']);
$redis->select($dbconfig['redis']['db']);

session_set_save_handler(new RedisSessionHandler($redis));
session_start();

$route = '';
$action = '';
$get = '';

if(isset($_GET['triad'])) {
    $route = $_GET['triad'];

    if(isset($_GET['action'])) {
        $action = $_GET['action'];

        if(isset($_GET['get']))
            $get = $_GET['get'];
    }
}

try {
    $twig = new Twig_Environment(new Twig_Loader_Filesystem('app/views/templates'));

    $router = new Router('app/routing/routes.php');

    // pass through GET and POST data? Or just access that data directly in the invoked classes?
    $fc = new FrontController($dic, $twig, $router, $route, $action, $get);

    // send out XML headers for HTML5 markup to be parsed as XHTML (to serve XHTML5)
    header('Content-Type: application/xhtml+xml');

    echo $fc->render($globalBindings);
}catch(Exception $e) {
    die($e);
}