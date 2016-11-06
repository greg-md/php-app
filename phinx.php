<?php

require_once __DIR__ . '/autoload.php';

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds',
    ],

    'environments' => [
        'default_migration_table' => 'Migrations',

        'default_database' => 'development',

        'production' => [
            'adapter' => 'mysql',
            'host' => app('db.dsn.host'),
            'name' => app('db.dsn.dbname'),
            'user' => app('db.username'),
            'pass' => app('db.password'),
            'port' => 3306,
            'charset' => 'utf8',
        ],

        'development' => [
            'adapter' => 'mysql',
            'host' => app('db.dsn.host'),
            'name' => app('db.dsn.dbname'),
            'user' => app('db.username'),
            'pass' => app('db.password'),
            'port' => 3306,
            'charset' => 'utf8',
        ],

        'testing' => [
            'adapter' => 'mysql',
            'host' => app('db.dsn.host'),
            'name' => app('db.dsn.dbname'),
            'user' => app('db.username'),
            'pass' => app('db.password'),
            'port' => 3306,
            'charset' => 'utf8',
        ],
    ],
];
