<?php

namespace App\Console;

class ConsoleKernel extends \Greg\Framework\Console\ConsoleKernel
{
    protected function boot()
    {
        $this->app()->ioc()->register($this->console());

        $this->bootstrap(new ConsoleBootstrap());
    }
}
