<?php

namespace App;

use App\Components\InitComponent;
use App\Components\TranslatorComponent;
use App\Console\ConsoleKernel;
use App\Http\HttpKernel;
use App\Misc\Options;
use Greg\ApplicationStrategy;
use Greg\Console\ConsoleKernelStrategy;
use Greg\Http\HttpKernelStrategy;

class Application extends \Greg\Application
{
    protected function boot()
    {
        $this->ioc()->addPrefixes([
            'App\\Services\\',
            'App\\Models\\',
        ]);

        $this->ioc()->concrete(ApplicationStrategy::class, $this);

        $this->ioc()->inject(ConsoleKernel::class);

        $this->ioc()->inject(ConsoleKernelStrategy::class, ConsoleKernel::class);

        $this->ioc()->inject(HttpKernel::class);

        $this->ioc()->inject(HttpKernelStrategy::class, HttpKernel::class);

        $this->ioc()->inject(Options::class);

        $this->addComponent(InitComponent::class);

        $this->addComponent(TranslatorComponent::class);
    }
}