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
    'index' => [['WebPageMapper'], 'IndexView', ''],
    'aboutme' => [['WebPageMapper'], 'AboutMeView', ''],
    'login' => [['UserMapper'], 'LoginView', 'LoginController'],
    'register' => [['UserMapper'], 'RegisterView', 'RegisterController'],
    'account' => [
        'index' => [['UserMapper'], 'AccountView', 'AccountController'],
        'updateInfo' => [['UserMapper'], 'AccountView', 'AccountInfoController']
    ],
    'admin' => [
        'index' => [['UserMapper'], 'AdminIndexView', 'AdminController'],
        'pages' => [['WebPageMapper'], 'AdminPagesView', ''],
        'page' => [['WebPageMapper'], 'AdminPageView', 'AdminPageController']
    ],
    'products' => [['ProductMapper', 'WebPageMapper'], 'ProductsView', 'ProductsController'],
    'product' => [['ProductMapper', 'WebPageMapper'], 'ProductView', ''],
    'posts' => [['PostMapper', 'WebPageMapper'], 'PostsView', 'PostsController'],
    'post' => [['PostMapper', 'WebPageMapper'], 'PostView', ''],
    'showthreads' => [['ThreadPostMapper'], 'ThreadsView', 'ThreadsController'],
    'showthread' => [['ThreadPostMapper'], 'ThreadView', 'ThreadController'],
    'newthread' => [['ThreadPostMapper'], 'NewThreadPostView', 'NewThreadPostController']
];