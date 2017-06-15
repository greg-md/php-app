<?php

return [
    'dsn' => [
        'host'    => env('db.host', '127.0.0.1'),
        'dbname'  => env('db.name', 'app'),
        'charset' => 'utf8',
    ],

    'username' => env('db.username', 'root'),
    'password' => env('db.password', ''),

    'options'  => [
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // time_zone = "+02:00"
    ],
];
