<?php

namespace App\Http;

use Greg\ApplicationStrategy;
use Greg\Http\HttpControllerTrait;
use Greg\View\Viewer;

class ControllerAbstract
{
    use HttpControllerTrait;

    protected $app = null;

    public function __construct(ApplicationStrategy $app)
    {
        $this->app = $app;

        return $this;
    }

    /**
     * @throws \Exception
     *
     * @return Viewer
     */
    protected function getViewer()
    {
        return $this->app->ioc()->expect(Viewer::class);
    }

    protected function render($name, array $params = [])
    {
        return $this->getViewer()->render($name, $params);
    }
}
