<?php

namespace App\Console;

use App\Console\Commands\ClearCacheCommand;

class ConsoleKernel extends \Greg\Framework\Console\ConsoleKernel
{
    protected function boot()
    {
        $this->addCommand(ClearCacheCommand::class);
    }
}