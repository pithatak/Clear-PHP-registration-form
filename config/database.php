<?php
return [
    'host' => getenv('MYSQL_HOST') ?: 'mysql',
    'dbname' => getenv('MYSQL_DATABASE') ?: 'clear_php',
    'user' => getenv('MYSQL_USER') ?: 'app_user',
    'password' => getenv('MYSQL_PASSWORD') ?: 'app_password',
    'charset' => getenv('MYSQL_CHARSET') ?: 'utf8mb4',
];
