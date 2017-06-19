<?php

namespace App\Console;

class ConsoleKernel extends \Greg\Framework\Console\ConsoleKernel
{
    protected function boot()
    {
        $this->app()->bootstrap(new ConsoleBootstrap());
    }
}
