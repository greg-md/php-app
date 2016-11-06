<?php

namespace App\Http\Components;

use App\Routes;
use Greg\Event\ListenerInterface;
use Greg\Event\SubscriberInterface;
use Greg\Http\HttpKernel;
use Greg\Router\Route;
use Greg\Router\Router;
use Greg\Support\Http\Request;
use Greg\Support\Http\Response;
use Greg\Support\Url;
use Greg\Translation\Translator;

class RouterComponent implements SubscriberInterface
{
    public function subscribe(ListenerInterface $listener)
    {
        $listener->register([
            HttpKernel::EVENT_RUN,
            HttpKernel::EVENT_DISPATCHING,
        ], $this);

        return $this;
    }

    public function httpRun(Router $router, Translator $translator)
    {
        $routes = new Routes($router, $translator);

        $routes->load();
    }

    public function httpDispatching($path, Route $route)
    {
        $this->checkRouteUri($path, $route);
    }

    protected function checkRouteUri($path, Route $route)
    {
        $realPath = $route->fetch($route->getCleanParams());

        if ($realPath !== $path) {
            Response::sendLocation(Url::addQuery($realPath, Request::uriQuery()), 301);

            die;
        }

        return $this;
    }
}
