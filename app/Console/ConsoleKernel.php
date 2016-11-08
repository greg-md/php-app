<?php

namespace App\Console;

use App\Console\Commands\HelloCommand;

class ConsoleKernel extends \Greg\Console\ConsoleKernel
{
    protected function boot()
    {
        $this->consoleApp()
            ->add(new HelloCommand());
    }
}