<?php

use Greg\Support\Server;
use Greg\Support\Session;

require_once __DIR__ . '/../vendor/autoload.php';

function env($index, $else = null)
{
    static $env;

    if ($env === null) {
        $env = require __DIR__ . '/../env.php';

        $env = \Greg\Support\Arr::fixIndexes($env);
    }

    return \Greg\Support\Arr::getIndex($env, $index, $else);
}

function dd(...$args)
{
    dump(...$args);

    die;
}

Server::iniSet('error_reporting', env('server.ini.error_reporting', -1));
Server::iniSet('display_errors', env('server.ini.display_errors', 1));
Server::iniSet('display_startup_errors', env('server.ini.display_startup_errors', 1));

Server::encoding('UTF-8');

Server::timezone('UTC');

Session::persistent(true);
