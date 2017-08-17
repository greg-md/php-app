<?php

namespace App;

use App\Console\ConsoleKernel;
use App\Http\HttpKernel;
use App\Resources\ImagixFormats;
use App\Resources\ViewDirectives;
use Greg\AppCache\CacheServiceProvider;
use Greg\AppDebugBar\DebugBarServiceProvider;
use Greg\AppImagix\Events\LoadImagixEvent;
use Greg\AppImagix\ImagixServiceProvider;
use Greg\AppOrm\OrmServiceProvider;
use Greg\AppView\Events\LoadViewerEvent;
use Greg\AppView\ViewServiceProvider;

class Application extends \Greg\AppInstaller\Application
{
    protected function bootApp()
    {
        $this->inject(HttpKernel::class, HttpKernel::class, $this);

        $this->inject(ConsoleKernel::class, ConsoleKernel::class, $this);

        $this->bootCacheServiceProvider();

        $this->bootDebugBarServiceProvider();

        $this->bootImagixServiceProvider();

        $this->bootOrmServiceProvider();

        $this->bootViewServiceProvider();
    }

    private function bootCacheServiceProvider()
    {
        $this->addServiceProvider(new CacheServiceProvider());
    }

    private function bootDebugBarServiceProvider()
    {
        if ($this['debug']) {
            $this->addServiceProvider(new DebugBarServiceProvider());
        }
    }

    private function bootImagixServiceProvider()
    {
        $this->addServiceProvider(new ImagixServiceProvider());

        $this->listen(LoadImagixEvent::class, function (LoadImagixEvent $event) {
            $this->ioc()->loadArgs(ImagixFormats::class, [$event->imagix()]);
        });
    }

    private function bootOrmServiceProvider()
    {
        $this->addServiceProvider(new OrmServiceProvider());
    }

    private function bootViewServiceProvider()
    {
        $this->addServiceProvider(new ViewServiceProvider());

        $this->listen(LoadViewerEvent::class, function (LoadViewerEvent $event) {
            $this->ioc()->loadArgs(ViewDirectives::class, [$event->viewer()]);
        });
    }
}
