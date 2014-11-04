<?php

/**
 * This file contains all information about the routes of the application.
 *
 * Super route format WITHOUT sub routes:
 * 'super_route_name' => [['ModelA', 'ModelB'], 'View', 'Controller'];
 *
 * Super route format WITH sub routes:
 * 'super_route_name' => [
 *     'sub_route_name1' => [['ModelA', 'ModelB'], 'View', 'Controller'],
 *     'sub_route_name2' => [['ModelA', 'ModelB'], 'View', 'Controller']
 * ];
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
    'account' => [
        'index' => [['UserMapper'], 'AccountView', 'AccountController']
    ],
    'products' => [['ProductMapper', 'WebPageContentMapper'], 'ProductsView', 'ProductsController'],
    'product' => [['ProductMapper', 'WebPageContentMapper'], 'ProductView', ''],
    'posts' => [['PostMapper', 'WebPageContentMapper'], 'PostsView', 'PostsController'],
    'post' => [['PostMapper', 'WebPageContentMapper'], 'PostView', ''],
    'showthreads' => [['ThreadPostMapper'], 'ThreadsView', 'ThreadsController'],
    'showthread' => [['ThreadPostMapper'], 'ThreadView', 'ThreadController'],
    'newthread' => [['ThreadPostMapper'], 'NewThreadPostView', 'NewThreadPostController']
];