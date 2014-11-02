<?php

/**
 * This file contains all information about the routes of the application.
 *
 * Route format:
 * route_hame_here => [['ModelA', 'ModelB'], 'View', 'Controller'];
 *
 * @package  Blop/app/routing
 * @author   Thomas Punt
 * @license  MIT
 */

return [
    'index' => [['WebPageContentMapper'], 'IndexView', ''],
    'aboutme' => [['WebPageContentMapper'], 'AboutMeView', ''],
    'login' => [['UserMapper'], 'LoginView', 'LoginController'],
    'register' => [['UserMapper'], 'RegisterView', 'RegisterController'],
    'account' => [['UserMapper'], 'AccountView', 'AccountController'],
    'products' => [['ProductMapper', 'WebPageContentMapper'], 'ProductsView', 'ProductsController'],
    'product' => [['ProductMapper', 'WebPageContentMapper'], 'ProductView', ''],
    'posts' => [['PostMapper', 'WebPageContentMapper'], 'PostsView', 'PostsController'],
    'post' => [['PostMapper', 'WebPageContentMapper'], 'PostView', ''],
    'showthreads' => [['ThreadPostMapper'], 'ThreadsView', 'ThreadsController'],
    'showthread' => [['ThreadPostMapper'], 'ThreadView', 'ThreadController'],
    'newthread' => [['ThreadPostMapper'], 'NewThreadPostView', 'NewThreadPostController']
];