<?php

namespace App\Console;

use App\Console\Commands\InstallCommand;
use App\Console\Commands\UninstallCommand;
use App\Resources\ConsoleCommands;

class ConsoleKernel extends \Greg\Framework\Console\ConsoleKernel
{
    protected function boot()
    {
        $this->app()->ioc()->register($this->console());

        $this->addCommand(InstallCommand::class);

        $this->addCommand(UninstallCommand::class);

        $this->app()->ioc()->load(ConsoleCommands::class, $this);
    }
}
