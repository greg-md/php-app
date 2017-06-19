<?php

namespace App\Http;

class HttpKernel extends \Greg\Framework\Http\HttpKernel
{
    protected function boot()
    {
        $this->app()->ioc()->register($this->router());

        $this->addControllersPrefixes('App\\Http\\Controllers\\');

        $this->bootstrap(new HttpBootstrap());
    }
}
