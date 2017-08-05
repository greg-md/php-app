<?php

require_once __DIR__ . '/setup.php';

function app($key = null)
{
    static $app;

    if ($app === null) {
        $config = \Greg\Support\Config::dir(__DIR__ . '/../config', 'app');

        $app = new \App\Application($config);

        $app->configure(__DIR__ . '/..');
    }

    return $key ? $app[$key] : $app;
}
