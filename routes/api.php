<?php

return [
    'POST /api/users' => [
        'controller' => \App\Controllers\UserController::class,
        'method' => 'create',
    ],
    'GET /api/users' => [
        'controller' => \App\Controllers\UserController::class,
        'method' => 'index',
    ],
    'GET /api/users/{id}' => [
        'controller' => \App\Controllers\UserController::class,
        'method' => 'show',
    ],
    'PUT /api/users/{id}' => [
        'controller' => \App\Controllers\UserController::class,
        'method' => 'update',
    ],
    'DELETE /api/users/{id}' => [
        'controller' => \App\Controllers\UserController::class,
        'method' => 'delete',
    ],
];
