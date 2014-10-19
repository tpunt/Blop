<?php
use app\routing\FrontController as FrontController;
use app\routing\Router as Router;
use app\models\DataAccessLayer\RedisSessionHandler as RedisSessionHandler;

// autoloaders
require 'autoloader.php'; // try to get rid of this and just use Composer's autoloader
$loader = require 'vendor/autoload.php';

// configurations
$dbconfig = require './config/dbconfig.php';
require './config/dicconfig.php';
$dic = new Dice\Dice;
configureDICE($dic, ['dbconfig' => $dbconfig]);

$redis = new Redis();
$redis->connect($dbconfig['redis']['host'], $dbconfig['redis']['port'], $dbconfig['redis']['timeout']);
$redis->select($dbconfig['redis']['db']);

session_set_save_handler(new RedisSessionHandler($redis));
session_start();

$route = '';
$action = '';

if(isset($_GET['triad'])) {
    $route = $_GET['triad'];

    if(!empty($_GET['action']))
        $action = $_GET['action'];

    // HTTP GET info
}

try {
    $twig = new Twig_Environment(new Twig_Loader_Filesystem('app/views/templates'));

    $router = new Router('app/routing/routes.php');

    // pass through GET and POST data? Or just access that data directly in the invoked classes?
    $fc = new FrontController($dic, $twig, $router, $route, $action);

    // send out XML headers for HTML5 markup to be parsed as XHTML (to serve XHTML5)
    header('Content-Type: application/xhtml+xml');
    echo $fc->render();
}catch(Exception $e) {
    die($e);
}