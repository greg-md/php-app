<?php

namespace App\Http;

use Greg\Cache\CacheManager;
use Greg\Framework\Bootstrap;
use Greg\Routing\RouteData;
use Greg\Support\Http\Request;
use Greg\Support\Http\Response;
use Greg\Support\Url;

class HttpBootstrap extends Bootstrap
{
    public function bootFixUriPath()
    {
        $path = Request::relativeUriPath();

        if (strlen($path) > 1 and substr($path, -1, 1) == '/') {
            Response::sendLocation(rtrim($path, '/'), 301);

            die;
        }
    }

    public function bootCleaner()
    {
        isset($_GET['op-reset']) && function_exists('opcache_reset') && opcache_reset();

        if (Request::hasGet('clear')) {
            $this->app()->scope(function (CacheManager $manager) {
                $manager->clear();
            });

            if (!Request::hasGet('no')) {
                Response::sendBack();

                die;
            }
        }
    }

    public function bootRouting()
    {
        $this->app()->listen(HttpKernel::EVENT_DISPATCHING, function(string $path, RouteData $data) {
            if ($data->path() !== $path) {
                Response::sendLocation(Url::addQuery($data->path(), Request::uriQuery()), 301);

                die;
            }
        });
    }

    public function bootRoutes()
    {
        $this->app()->listen(HttpKernel::EVENT_RUN, function(HttpKernel $kernel) {
            $routes = new Routes($this->app(), $kernel->router());

            $routes->load();
        });
    }
}