<?php

use Greg\Orm\Driver\DriverManager;

require_once __DIR__ . '/bootstrap/app.php';

/** @var DriverManager $driver */
$driver = app()->ioc()->expect(\Greg\Orm\Driver\DriverManager::class);

/** @var \Greg\Orm\Driver\MysqlDriver $mysql */
$mysql = $driver->driver('base');

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds'      => '%%PHINX_CONFIG_DIR%%/db/seeds',
    ],

    'environments' => [
        'default_migration_table' => 'Migrations',
        'default_database'        => 'application',

        'application' => [
            'name'       => app('mysql.database'),
            'connection' => $mysql->pdo()->connection(),
        ],
    ],
];
