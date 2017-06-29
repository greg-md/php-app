<?php

namespace App\ServiceProviders\App;

use App\Application;
use App\Console\ConsoleKernel;
use App\ServiceProviders\App\Commands\InstallCommand;
use App\ServiceProviders\App\Commands\UninstallCommand;
use App\ServiceProviders\App\Events\ConfigAddEvent;
use App\ServiceProviders\App\Events\ConfigRemoveEvent;
use App\ServiceProviders\App\Events\PublicAddEvent;
use App\ServiceProviders\App\Events\PublicRemoveEvent;
use Greg\Framework\ServiceProvider;

class AppServiceProvider implements ServiceProvider
{
    public function name()
    {
        return 'app';
    }

    public function boot(Application $app)
    {
        $app->listen('app.config.add', ConfigAddEvent::class);
        $app->listen('app.config.remove', ConfigRemoveEvent::class);

        $app->listen('app.public.add', PublicAddEvent::class);
        $app->listen('app.public.remove', PublicRemoveEvent::class);
    }

    public function bootConsoleKernel(ConsoleKernel $kernel)
    {
        $kernel->addCommand(InstallCommand::class);

        $kernel->addCommand(UninstallCommand::class);
    }
}
