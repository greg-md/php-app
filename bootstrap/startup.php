<?php

function appEnv($key, $else = null)
{
    static $settings;

    if ($settings === null) {
        $settings = \Greg\Support\Arr::fixIndexes(require __DIR__ . '/../env.php');
    }

    return \Greg\Support\Arr::getIndex($settings, $key, $else);
}

function app()
{
    static $app;

    if ($app === null) {
        $settings = \Greg\Support\Config\ConfigDir::path(__DIR__ . '/../config');

        $app = new \Greg\Application($settings, appEnv('app_name'));

        $app->init();
    }

    return $app;
}