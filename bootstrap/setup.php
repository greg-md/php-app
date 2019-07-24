<?php

require_once __DIR__ . '/../vendor/autoload.php';

Greg\Support\Server::loadEnvironmentFile(__DIR__ . '/../.env');

Greg\Support\Server::iniSet('error_reporting', getenv('DISPLAY_ERRORS') ? -1 : 0);
Greg\Support\Server::iniSet('display_errors', getenv('DISPLAY_ERRORS') ?: 1);
Greg\Support\Server::iniSet('display_startup_errors', getenv('DISPLAY_ERRORS') ?: 1);

Greg\Support\Server::encoding('UTF-8');

Greg\Support\Server::timezone('UTC');

Greg\Support\Session::persistent(true);
