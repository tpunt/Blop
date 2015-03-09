<?php

use app\routing\FrontController;
use app\routing\Router;
use app\models\DataAccessLayer\RedisSessionHandler;

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

$params = [
    isset($_GET['param1']) ? $_GET['param1'] : '',
    isset($_GET['param2']) ? $_GET['param2'] : '',
    isset($_GET['param3']) ? $_GET['param3'] : '',
    isset($_GET['param4']) ? $_GET['param4'] : ''
];

try {
    $twig = new Twig_Environment(new Twig_Loader_Filesystem('app/views/templates'));

    $router = new Router('app/routing/routes.php');

    // pass through GET and POST data? Or just access that data directly in the invoked classes?
    $fc = new FrontController($dic, $twig, $router, $params);

    // send out XML headers for HTML5 markup to be parsed as XHTML (to serve XHTML5)
    header('Content-Type: application/xhtml+xml');

    echo $fc->render($globalBindings);
}catch(Exception $e) {
    die($e);
}