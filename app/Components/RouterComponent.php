<?php

namespace App\Components;

use App\Routes;
use Greg\Application;
use Greg\Event\ListenerInterface;
use Greg\Event\SubscriberInterface;
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
            Application::EVENT_RUN,
            Application::EVENT_DISPATCHING,
        ], $this);

        return $this;
    }

    public function appRun(Router $router, Translator $translator)
    {
        $routes = new Routes($router, $translator);

        $routes->load();
    }

    public function appDispatching($path, Route $route)
    {
        $this->checkRouteUri($path, $route);
    }

    public function checkRouteUri($path, Route $route)
    {
        $realPath = $route->fetch($route->getCleanParams());

        if ($realPath !== $path) {
            Response::sendLocation(Url::addQuery($realPath, Request::uriQuery()), 301);

            die;
        }

        return $this;
    }
}
