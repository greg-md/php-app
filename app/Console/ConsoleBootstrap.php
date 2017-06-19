<?php

namespace App\Console;

use App\Resources\ConsoleCommands;
use Greg\Framework\BootstrapAbstract;

class ConsoleBootstrap extends BootstrapAbstract
{
    public function bootCommands()
    {
        $this->app()->ioc()->load(ConsoleCommands::class);
    }
}
