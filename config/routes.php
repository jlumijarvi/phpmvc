<?php

return [
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
];