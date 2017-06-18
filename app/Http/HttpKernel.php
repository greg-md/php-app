<?php

namespace App\Http;

class HttpKernel extends \Greg\Framework\Http\HttpKernel
{
    protected function boot()
    {
        $this->addControllersPrefixes('App\\Http\\Controllers\\');

        $this->app()->bootstrap(new HttpBootstrap());
    }
}