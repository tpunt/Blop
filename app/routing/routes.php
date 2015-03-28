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
    'about' => [['WebPageMapper'], 'AboutMeView', ''],
    'login' => [['WebPageMapper', 'UserMapper'], 'LoginView', 'LoginController'],
    'register' => [['WebPageMapper', 'UserMapper'], 'RegisterView', 'RegisterController'],
    'account' => [
        'index' => [['UserMapper'], 'AccountView', 'AccountController'],
        'updateInfo' => [['UserMapper'], 'AccountView', 'AccountInfoController']
    ],
    'admin' => [
        'index' => [['UserMapper'], 'AdminIndexView', 'AdminController'],
        'pages' => [['WebPageMapper'], 'AdminPagesView', 'AdminController'],
        'page' => [['WebPageMapper'], 'AdminPageView', 'AdminPageController'],
        'posts' => [['PostMapper'], 'AdminPostsView', 'AdminController'],
        'post' => [['PostMapper'], 'AdminPostView', 'AdminPostController']
    ],
    'products' => [['WebPageMapper', 'ProductMapper'], 'ProductsView', 'ProductsController'],
    'product' => [['WebPageMapper', 'ProductMapper'], 'ProductView', ''],
    'posts' => [['WebPageMapper', 'PostMapper'], 'PostsView', 'PostsController'],
    'post' => [['WebPageMapper', 'PostMapper'], 'PostView', ''],
];