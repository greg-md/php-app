<?php

require_once __DIR__ . '/vendor/autoload.php';

function env($index, $else = null)
{
    static $env;

    if ($env === null) {
        $env = require __DIR__ . '/env.php';

        $env = \Greg\Support\Arr::fixIndexes($env);
    }

    return \Greg\Support\Arr::getIndex($env, $index, $else);
}

function app($key = null)
{
    static $app;

    if ($app === null) {
        $config = new \Greg\Framework\Config(
            \Greg\Support\Config::dir(__DIR__ . '/config', 'app')
        );

        $app = new \App\Application($config);
    }

    if (func_num_args()) {
        return $app[$key];
    }

    return $app;
}

function dd(...$args)
{
    dump(...$args);

    die;
}

return app();
