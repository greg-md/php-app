<?php

namespace App\Http\Components;

use DebugBar\JavascriptRenderer;
use DebugBar\StandardDebugBar;
use Greg\Application;
use Greg\Event\ListenerInterface;
use Greg\Event\SubscriberInterface;
use Greg\Http\HttpKernel;
use Greg\Support\Http\Request;
use Greg\Support\Http\Response;

class DebugComponent implements SubscriberInterface
{
    protected $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function initDebugBar()
    {
        $this->app->inject(StandardDebugBar::class);

        $this->app->inject(JavascriptRenderer::class, function (StandardDebugBar $bar) {
            return $bar->getJavascriptRenderer('/debug');
        });
    }

    public function subscribe(ListenerInterface $listener)
    {
        $listener->register([
            HttpKernel::EVENT_FINISHED
        ], $this);

        return $this;
    }

    public function httpFinished(Response $response)
    {
        if ($this->app->debugMode() and !Request::isAjax() and $response->isHtml()) {
            $this->app->scope(function (JavascriptRenderer $renderer) use ($response) {
                $response->setContent(
                    $response->getContent() .
                    '<span></span>' .
                    $renderer->renderHead() .
                    $renderer->render()
                );
            });
        }
    }
}
