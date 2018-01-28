<?php

return [
    // Home
    [
        'pattern' => '',
        'controller' => \Controllers\HomeController::class
    ],
    [
        'pattern' => 'about',
        'controller' => \Controllers\HomeController::class,
        'action' => 'about'
    ],
    [
        'pattern' => 'authorized',
        'controller' => \Controllers\HomeController::class,
        'action' => 'authorized'
    ],
    [
        'pattern' => 'signin',
        'controller' => \Controllers\HomeController::class,
        'action' => 'signin'
    ],

    // Users
    [
        'pattern' => 'users',
        'controller' => \Controllers\UsersController::class
    ],
    [
        'pattern' => 'users\/([A-z0-9]+)',
        'controller' => \Controllers\UsersController::class,
        'action' => 'show'
    ],
];