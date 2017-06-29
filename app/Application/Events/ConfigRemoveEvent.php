<?php

namespace App\Application\Events;

use App\Application;
use Greg\Support\Dir;

class ConfigRemoveEvent
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(string $name)
    {
        $source = getcwd() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . pathinfo($name, PATHINFO_FILENAME);

        if (!is_dir($source)) {
            $source .= '.php';

            if (!is_file($source)) {
                return;
            }
        }

        Dir::unlink($source);
    }
}