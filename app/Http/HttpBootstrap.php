<?php

namespace App\Http;

use App\Resources\HttpRoutes;
use Greg\Framework\Http\BootstrapAbstract;
use Greg\Support\Http\Request;
use Greg\Support\Http\Response;

class HttpBootstrap extends BootstrapAbstract
{
    public function bootFixUriPath()
    {
        $path = Request::relativeUriPath();

        if (strlen($path) > 1 and substr($path, -1, 1) === '/') {
            Response::sendLocation(rtrim($path, '/'), 301);

            die;
        }
    }

    public function bootRoutes()
    {
        $this->app()->listen(HttpKernel::EVENT_RUN, function () {
            $this->ioc()->load(HttpRoutes::class);
        });
    }
}
