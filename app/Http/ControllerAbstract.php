<?php

namespace App\Http;

use App\Application;
use Greg\Framework\Http\HttpControllerTrait;
use Greg\View\ViewerContract;

class ControllerAbstract
{
    use HttpControllerTrait;

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;

        return $this;
    }

    protected function app(): Application
    {
        return $this->app;
    }

    /**
     * @throws \Exception
     *
     * @return ViewerContract
     */
    protected function viewer()
    {
        return $this->app->ioc()->expect(ViewerContract::class);
    }

    protected function render($name, array $params = [])
    {
        return $this->viewer()->render($name, $params);
    }
}
