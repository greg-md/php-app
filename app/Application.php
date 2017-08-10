<?php

namespace App;

use App\Console\ConsoleKernel;
use App\Http\HttpKernel;
use App\Resources\StaticImages;
use App\Resources\ViewDirectives;
use Greg\AppCache\CacheServiceProvider;
use Greg\AppDebugBar\DebugBarServiceProvider;
use Greg\AppOrm\OrmServiceProvider;
use Greg\AppStaticImage\Events\LoadStaticImageManagerEvent;
use Greg\AppStaticImage\StaticImageServiceProvider;
use Greg\AppView\Events\LoadViewerEvent;
use Greg\AppView\ViewServiceProvider;

class Application extends \Greg\AppInstaller\Application
{
    protected function bootApp()
    {
        $this->inject(HttpKernel::class, HttpKernel::class, $this);

        $this->inject(ConsoleKernel::class, ConsoleKernel::class, $this);

        $this->bootViewServiceProvider();

        $this->bootStaticImageProvider();

        $this->addServiceProvider(new CacheServiceProvider());
        $this->addServiceProvider(new DebugBarServiceProvider());
        $this->addServiceProvider(new OrmServiceProvider());
    }

    private function bootViewServiceProvider()
    {
        $this->addServiceProvider(new ViewServiceProvider());

        $this->listen(LoadViewerEvent::class, function (LoadViewerEvent $event) {
            $this->ioc()->loadArgs(ViewDirectives::class, [$event->viewer()]);
        });
    }

    private function bootStaticImageProvider()
    {
        $this->addServiceProvider(new StaticImageServiceProvider());

        $this->listen(LoadStaticImageManagerEvent::class, function (LoadStaticImageManagerEvent $event) {
            $this->ioc()->loadArgs(StaticImages::class, [$event->manager()]);
        });
    }
}
