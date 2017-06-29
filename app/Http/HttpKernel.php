<?php

namespace App\Http;

use App\Resources\HttpRoutes;
use Greg\Support\Http\Request;
use Greg\Support\Http\Response;

class HttpKernel extends \Greg\Framework\Http\HttpKernel
{
    protected function boot()
    {
        $this->bootFixUriPath();

        $this->app()->ioc()->register($this->router());

        $this->addControllersPrefixes('App\\Http\\Controllers\\');

        $this->app()->ioc()->load(HttpRoutes::class);
    }

    public function bootFixUriPath()
    {
        $path = Request::relativeUriPath();

        if (strlen($path) > 1 and substr($path, -1, 1) === '/') {
            Response::sendLocation(rtrim($path, '/'), 301);

            die;
        }
    }
}
