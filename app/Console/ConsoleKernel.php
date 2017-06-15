<?php

namespace App\Console;

use App\Console\Commands\HelloCommand;

class ConsoleKernel extends \Greg\Framework\Console\ConsoleKernel
{
    protected function boot()
    {
        $this->console()->add(new HelloCommand());
    }
}