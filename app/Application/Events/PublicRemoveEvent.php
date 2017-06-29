<?php

namespace App\Application\Events;

use App\Application;
use Greg\Support\Dir;

class PublicRemoveEvent
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(string $baseUrl)
    {
        $path = getcwd() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $baseUrl;

        Dir::unlink($path);
    }
}