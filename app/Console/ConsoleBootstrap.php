<?php

namespace App\Console;

use App\Resources\ConsoleCommands;
use Greg\Framework\Console\BootstrapAbstract;

class ConsoleBootstrap extends BootstrapAbstract
{
    public function bootCommands()
    {
        $this->ioc()->load(ConsoleCommands::class, $this->kernel());
    }
}
