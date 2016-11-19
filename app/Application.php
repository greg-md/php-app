<?php

namespace App;

use App\Components\InitComponent;
use App\Components\TranslatorComponent;
use App\Console\ConsoleKernel;
use App\Http\HttpKernel;
use App\Misc\Settings;
use Greg\ApplicationContract;
use Greg\Console\ConsoleKernelContract;
use Greg\Http\HttpKernelContract;

class Application extends \Greg\Application
{
    protected function boot()
    {
        $this->ioc()->addPrefixes([
            'App\\Services\\',
            'App\\Models\\',
        ]);

        $this->ioc()->concrete(ApplicationContract::class, $this);

        $this->ioc()->inject(ConsoleKernel::class);

        $this->ioc()->inject(ConsoleKernelContract::class, ConsoleKernel::class);

        $this->ioc()->inject(HttpKernel::class);

        $this->ioc()->inject(HttpKernelContract::class, HttpKernel::class);

        $this->ioc()->inject(Settings::class);

        $this->addComponent(InitComponent::class);

        $this->addComponent(TranslatorComponent::class);
    }
}