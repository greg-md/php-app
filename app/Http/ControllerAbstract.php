<?php

namespace App\Http;

use Greg\ApplicationContract;
use Greg\Http\HttpControllerTrait;
use Greg\View\ViewerContract;

class ControllerAbstract
{
    use HttpControllerTrait;

    protected $app = null;

    public function __construct(ApplicationContract $app)
    {
        $this->app = $app;

        return $this;
    }

    /**
     * @throws \Exception
     *
     * @return ViewerContract
     */
    protected function getViewer()
    {
        return $this->app->ioc()->expect(ViewerContract::class);
    }

    protected function render($name, array $params = [])
    {
        return $this->getViewer()->render($name, $params);
    }
}
