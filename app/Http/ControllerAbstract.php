<?php

namespace App\Http;

use Greg\Application;
use Greg\Http\ControllerTrait;
use Greg\View\Viewer;

class ControllerAbstract
{
    use ControllerTrait;

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
        return $this->app->make(Viewer::class);
    }

    protected function render($name, array $params = [], $layout = null, $_ = null)
    {
        return $this->getViewer()->render(...func_get_args());
    }
}
