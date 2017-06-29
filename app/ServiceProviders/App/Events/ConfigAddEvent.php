<?php

namespace App\ServiceProviders\App\Events;

use App\Application;
use Greg\Support\Config;
use Greg\Support\Dir;

class ConfigAddEvent
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(string $source, string $name)
    {
        $isFile = is_file($source);

        $destinationName = $isFile ? $name . '.php' : $name;

        $configPath = getcwd() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $destinationName;

        Dir::copy($source, $configPath);

        if ($isFile) {
            $config = require $configPath;
        } else {
            $config = Config::dir($configPath);
        }

        $this->app->addConfig($name, $config);
    }
}
