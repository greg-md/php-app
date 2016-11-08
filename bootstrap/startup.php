<?php

function appEnv($key, $else = null)
{
    static $env;

    if ($env === null) {
        $env = \Greg\Support\Arr::fixIndexes(require __DIR__ . '/../env.php');
    }

    return \Greg\Support\Arr::getIndex($env, $key, $else);
}

function app($key = null)
{
    static $app;

    if ($app === null) {
        $app = new \App\Application(\Greg\Support\Config\ConfigDir::path(__DIR__ . '/../config', 'app'));
    }

    if (func_num_args()) {
        return $app[$key];
    }

    return $app;
}

trait AppTrait
{
    protected function app()
    {
        return app();
    }
}
