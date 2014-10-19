<?php

/**
 * Route format:
 * route_hame_here => [['ModelA', 'ModelB'], 'View', 'Controller'];
 */

return [
    'index' => [['WebPageContentMapper'], 'IndexView', ''],
    'aboutme' => [['WebPageContentMapper'], 'AboutMeView', ''],
    'login' => [['UserMapper'], 'LoginView', 'LoginController'],
    'register' => [['UserMapper'], 'RegisterView', 'RegisterController'],
    'account' => [['UserMapper'], 'AccountView', 'AccountController'],
    'showthreads' => [['ThreadPostMapper'], 'ThreadsView', 'ThreadsController'],
    'showthread' => [['ThreadPostMapper'], 'ThreadView', 'ThreadController'],
    'newthread' => [['ThreadPostMapper'], 'NewThreadPostView', 'NewThreadPostController']
];