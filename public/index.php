<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\UserService;

$userService = new UserService();

echo $userService->hello();