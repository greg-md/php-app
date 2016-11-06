<?php

return [
    'dsn' => [
        'host'    => appEnv('db.host', '127.0.0.1'),
        'dbname'  => appEnv('db.name', 'app'),
        'charset' => 'utf8',
    ],

    'username' => appEnv('db.username', 'root'),
    'password' => appEnv('db.password', ''),

    'options'  => [
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // time_zone = "+02:00"
    ],
];
