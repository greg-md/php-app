<?php

use Greg\Support\Server;
use Greg\Support\Session;

require_once __DIR__ . '/../vendor/autoload.php';

function dd(...$args)
{
    dump(...$args);

    die;
}

Server::iniSet('error_reporting', getenv('DISPLAY_ERRORS') ? 0 : -1);
Server::iniSet('display_errors', getenv('DISPLAY_ERRORS') ?: 1);
Server::iniSet('display_startup_errors', getenv('DISPLAY_ERRORS') ?: 1);

Server::encoding('UTF-8');

Server::timezone('UTC');

Session::persistent(true);
