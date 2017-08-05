<?php

namespace App;

use App\Console\ConsoleKernel;
use App\Http\HttpKernel;
use App\Resources\StaticImages;
use App\Resources\ViewDirectives;
use Greg\AppStaticImage\Events\LoadStaticImageManagerEvent;
use Greg\AppStaticImage\StaticImageServiceProvider;
use Greg\AppView\Events\LoadViewerEvent;
use Greg\AppView\ViewServiceProvider;

class Application extends \Greg\AppInstaller\Application
{
    protected function bootApp()
    {
        $this->ioc()->inject(HttpKernel::class, function () {
            return new HttpKernel($this);
        });

        $this->ioc()->inject(ConsoleKernel::class, function () {
            return new ConsoleKernel($this);
        });

        $this->bootViewServiceProvider();

        $this->bootStaticImageProvider();
    }

    private function bootViewServiceProvider()
    {
        $this->addServiceProvider(new ViewServiceProvider());

        $this->listen(LoadViewerEvent::class, function (LoadViewerEvent $event) {
            $this->ioc()->load(ViewDirectives::class, $event->viewer());
        });
    }

    private function bootStaticImageProvider()
    {
        $this->addServiceProvider(new StaticImageServiceProvider());

        $this->listen(LoadStaticImageManagerEvent::class, function (LoadStaticImageManagerEvent $event) {
            $this->ioc()->load(StaticImages::class, $event->manager());
        });
    }
}
