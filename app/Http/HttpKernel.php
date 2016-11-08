<?php

namespace App\Http;

use App\Http\Components\DebugComponent;
use App\Http\Components\RouterComponent;

class HttpKernel extends \Greg\Http\HttpKernel
{
    protected $controllersPrefixes = [
        'App\\Http\\Controllers\\',
    ];

    protected function boot()
    {
        $this->app()->addComponent(RouterComponent::class);

        $this->app()->addComponent(DebugComponent::class);
    }
}