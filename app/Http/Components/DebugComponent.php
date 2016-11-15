<?php

namespace App\Http\Components;

use DebugBar\JavascriptRenderer;
use DebugBar\StandardDebugBar;
use Greg\ApplicationContract;
use Greg\Http\HttpKernel;
use Greg\Support\Http\Request;
use Greg\Support\Http\Response;

class DebugComponent
{
    protected $app = null;

    public function __construct(ApplicationContract $app)
    {
        $this->app = $app;

        $this->app->on([
            HttpKernel::EVENT_FINISHED
        ], $this);
    }

    public function initDebugBar()
    {
        $this->app->ioc()->inject(StandardDebugBar::class);

        $this->app->ioc()->inject(JavascriptRenderer::class, function (StandardDebugBar $bar) {
            return $bar->getJavascriptRenderer('/debug');
        });
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
