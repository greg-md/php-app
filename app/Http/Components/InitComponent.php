<?php

namespace App\Http\Components;

use Greg\ApplicationContract;
use Greg\Cache\CacheManager;
use Greg\Support\Http\Request;
use Greg\Support\Http\Response;

class InitComponent
{
    protected $app = null;

    public function __construct(ApplicationContract $app)
    {
        $this->app = $app;
    }

    public function initFixPath()
    {
        $path = Request::relativeUriPath();

        if (strlen($path) > 1 and substr($path, -1, 1) == '/') {
            Response::sendLocation(rtrim($path, '/'), 301);

            die;
        }
    }

    public function initCleaner()
    {
        isset($_GET['op-reset']) && function_exists('opcache_reset') && opcache_reset();

        if (Request::hasGet('clear')) {
            $this->app->scope(function (CacheManager $manager) {
                $manager->delete();
            });

            if (!Request::hasGet('no')) {
                Response::sendBack();

                die;
            }
        }
    }
}