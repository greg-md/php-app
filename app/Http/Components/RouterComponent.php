<?php

namespace App\Http\Components;

use App\Http\Routes;
use Greg\ApplicationContract;
use Greg\Http\HttpKernel;
use Greg\Http\HttpKernelContract;
use Greg\Router\Route;
use Greg\Support\Http\Request;
use Greg\Support\Http\Response;
use Greg\Support\Url;

class RouterComponent
{
    public function __construct(ApplicationContract $app)
    {
        $app->on([
            HttpKernel::EVENT_RUN,
            HttpKernel::EVENT_DISPATCHING,
        ], $this);
    }

    public function httpRun(ApplicationContract $app, HttpKernelContract $kernel)
    {
        $routes = new Routes($app, $kernel->router());

        $routes->load();
    }

    public function httpDispatching($path, Route $route)
    {
        $realPath = $route->fetch($route->getCleanParams());

        if ($realPath !== $path) {
            Response::sendLocation(Url::addQuery($realPath, Request::uriQuery()), 301);

            die;
        }
    }
}
