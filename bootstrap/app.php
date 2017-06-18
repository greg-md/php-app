<?php

require_once __DIR__ . '/setup.php';

function app($key = null)
{
    static $app;

    if ($app === null) {
        $config = new \Greg\Framework\Config(
            \Greg\Support\Config::dir(__DIR__ . '/../config', 'app')
        );

        $app = new \App\Application($config);
    }

    return $key ? $app[$key] : $app;
}
