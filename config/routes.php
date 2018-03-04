<?php

return [
    // Home
    [
        'pattern' => '',
        'controller' => \Controllers\HomeController::class,
        'name' => 'home'
    ],
    [
        'pattern' => 'about',
        'controller' => \Controllers\HomeController::class,
        'action' => 'about',
        'name' => 'about'
    ],
    [
        'pattern' => 'authorized',
        'controller' => \Controllers\HomeController::class,
        'action' => 'authorized'
    ],
    [
        'pattern' => 'signin',
        'controller' => \Controllers\HomeController::class,
        'action' => 'signin',
        'name' => 'signin'
    ],

    // Users
    [
        'pattern' => 'users',
        'controller' => \Controllers\UsersController::class,
        'name' => 'users'
    ],
    [
        'pattern' => 'users\/([A-z0-9]+)',
        'controller' => \Controllers\UsersController::class,
        'action' => 'show',
        'name' => 'user'
    ],
];