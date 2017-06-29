<?php

namespace App\Console;

use App\Resources\ConsoleCommands;

class ConsoleKernel extends \Greg\Framework\Console\ConsoleKernel
{
    protected function boot()
    {
        $this->app()->ioc()->register($this->console());

        $this->app()->ioc()->load(ConsoleCommands::class, $this);
    }
}
