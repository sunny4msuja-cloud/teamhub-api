<?php

return [
    'host' => getenv('DB_HOST') ?: 'database',
    'port' => getenv('DB_PORT') ?: '3306',
    'database' => getenv('DB_DATABASE') ?: 'teamhub',
    'username' => getenv('DB_USERNAME') ?: 'teamhub',
    'password' => getenv('DB_PASSWORD'),
];