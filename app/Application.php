<?php

namespace App;

use App\Console\ConsoleKernel;
use App\Http\HttpKernel;

class Application extends \Greg\Framework\Application
{
    protected function boot()
    {
        $this->ioc()->register($this);

        $this->ioc()->inject(HttpKernel::class, function () {
            return new HttpKernel($this);
        });

        $this->ioc()->inject(ConsoleKernel::class, function () {
            return new ConsoleKernel($this);
        });

        $this->bootstrap(new Bootstrap());
    }
}
