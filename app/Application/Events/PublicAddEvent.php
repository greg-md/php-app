<?php

namespace App\Application\Events;

use App\Application;
use Greg\Support\Dir;

class PublicAddEvent
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(string $source, string $baseUrl)
    {
        $destination = getcwd() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . ltrim($baseUrl, '/');

        Dir::copy($source, $destination);
    }
}