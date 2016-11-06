<?php

namespace App\Http;

use Greg\Application;
use Greg\Http\HttpControllerTrait;
use Greg\View\Viewer;

class ControllerAbstract
{
    use HttpControllerTrait;

    protected $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @throws \Exception
     *
     * @return Viewer
     */
    protected function getViewer()
    {
        return $this->app->expect(Viewer::class);
    }

    protected function render($name, array $params = [])
    {
        return $this->getViewer()->render($name, $params);
    }
}
