<?php

namespace App\Console;

use App\Console\Commands\ClearCacheCommand;

class ConsoleKernel extends \Greg\Framework\Console\ConsoleKernel
{
    protected function boot()
    {
        $this->app()->bootstrap(new ConsoleBootstrap());

        $this->addCommand(ClearCacheCommand::class);
    }
}
