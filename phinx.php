<?php

require_once __DIR__ . '/bootstrap/app.php';

/** @var \Greg\Orm\Driver\MysqlDriver $mysql */
$mysql = app()->ioc()->get('mysql');

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
