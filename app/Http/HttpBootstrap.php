<?php

namespace App\Http;

use App\Application;
use DebugBar\JavascriptRenderer;
use DebugBar\StandardDebugBar;
use Greg\Cache\CacheManager;
use Greg\Framework\BootstrapAbstract;
use Greg\Routing\RouteData;
use Greg\Support\Http\Request;
use Greg\Support\Http\Response;
use Greg\Support\Url;

class HttpBootstrap extends BootstrapAbstract
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

    public function bootFixRoutingPath()
    {
        $this->app()->listen(HttpKernel::EVENT_DISPATCHING, function (string $path, RouteData $data) {
            if ($data->path() !== $path) {
                Response::sendLocation(Url::addQuery($data->path(), Request::uriQuery()), 301);

                die;
            }
        });
    }

    public function bootRoutes(Application $application)
    {
        $application->listen(HttpKernel::EVENT_RUN, function (HttpKernel $kernel) use ($application) {
            $routes = new Routes($application, $kernel->router());

            $routes->load();
        });
    }

    public function bootDebugBar()
    {
        $this->app()->ioc()->inject(StandardDebugBar::class, function () {
            return new StandardDebugBar();
        });

        $this->app()->ioc()->inject(JavascriptRenderer::class, function (StandardDebugBar $bar) {
            return $bar->getJavascriptRenderer('/debug');
        });

        $this->app()->listen(HttpKernel::EVENT_FINISHED, function (Response $response, JavascriptRenderer $renderer) {
            if ($this->app()['debug'] and !Request::isAjax() and $response->isHtml()) {
                $response->setContent(
                    $response->getContent() . '<span></span>' . $renderer->renderHead() . $renderer->render()
                );
            }
        });
    }
}