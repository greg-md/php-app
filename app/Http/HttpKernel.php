<?php

namespace App\Http;

use App\Resources\HttpRoutes;

class HttpKernel extends \Greg\Framework\Http\HttpKernel
{
    protected function boot()
    {
        $this->app()->ioc()->register($this->router());

        $this->addControllersPrefixes('App\\Http\\Controllers\\');

        $this->app()->ioc()->load(HttpRoutes::class);
    }
}
