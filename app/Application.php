<?php

namespace App;

use App\Components\InitComponent;
use App\Console\ConsoleKernel;
use App\Http\HttpKernel;
use Greg\Console\ConsoleKernelContract;
use Greg\Http\HttpKernelContract;

class Application extends \Greg\Application
{
    protected function boot()
    {
        $this->ioc()->addPrefixes([
            'App\\Models\\',
        ]);

        $this->ioc()->inject(ConsoleKernelContract::class, ConsoleKernel::class);

        $this->ioc()->inject(HttpKernelContract::class, HttpKernel::class);

        $this->addComponent(InitComponent::class);
    }
}