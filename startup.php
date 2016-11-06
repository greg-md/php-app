<?php

// Server configuration

\Greg\Support\ServerIni::setAll([
    'display_startup_errors' => appEnv('server.ini.display_startup_errors', 1),
    'display_errors'         => appEnv('server.ini.display_errors', 1),
    'error_reporting'        => appEnv('server.ini.error_reporting', -1),
]);

\Greg\Support\ServerConfig::encoding('UTF-8');

\Greg\Support\ServerConfig::timezone('UTC');

// Session configuration

\Greg\Support\Session::persistent(true);

\Greg\Support\Session::setIniMore([
    //'gc_maxlifetime' => 86400,
    //'cookie_lifetime' => 86400,
    //'save_handler' => 'redis',
    //'save_path' => 'tcp://127.0.0.1:6379?prefix=session',
    //'save_path' => __DIR__ . '/../storage/session',
    'save_path' => '/tmp',
]);

function dd(...$args)
{
    dump(...$args);

    die;
}
