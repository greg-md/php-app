<?php

namespace App\Resources;

use App\Console\Commands\HelloCommand;
use App\Console\ConsoleKernel;

class ConsoleCommands
{
    private $kernel;

    public function __construct(ConsoleKernel $kernel)
    {
        $this->kernel = $kernel;

        $this->boot();
    }

    private function boot()
    {
        $this->kernel->addCommand(HelloCommand::class);
    }
}
