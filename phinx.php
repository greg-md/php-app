<?php

/** @var \App\Application $app */
$app = require_once __DIR__ . '/bootstrap/app.php';

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds',
    ],

    'environments' => [
        'default_migration_table' => 'Migrations',
        'default_database' => 'application',

        'application' => [
            //'connection' => $pdo,
            'adapter' => 'mysql',
            'host' => $app['db.dsn.host'],
            'name' => $app['db.dsn.dbname'],
            'user' => $app['db.username'],
            'pass' => $app['db.password'],
            'port' => 3306,
            'charset' => 'utf8',
        ],
    ],
];
