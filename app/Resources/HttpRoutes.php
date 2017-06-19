<?php

namespace App\Resources;

use Greg\Routing\Router;

class HttpRoutes
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;

        $this->boot();
    }

    private function boot()
    {
        $this->router->get('/', 'HomeController@index');
    }
}
