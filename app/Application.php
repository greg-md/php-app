<?php

namespace App;

use App\Console\ConsoleKernel;
use App\Http\HttpKernel;
use App\Resources\StaticImages;
use App\Resources\ViewDirectives;
use Greg\AppView\Events\LoadViewerEvent;
use Greg\AppView\ViewServiceProvider;
use Greg\StaticImage\ImageDecoratorStrategy;
use Greg\StaticImage\StaticImageManager;
use Greg\Support\Str;
use Intervention\Image\ImageManager;

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

        $this->addServiceProvider(new ViewServiceProvider());

        $this->bootStaticImage();

        $this->listen(LoadViewerEvent::class, function () {
            $this->ioc()->load(ViewDirectives::class);
        });
    }

    private function bootStaticImage()
    {
        $this->ioc()->inject(StaticImageManager::class, function () {
            $decorator = new class() implements ImageDecoratorStrategy {
                private $uri = '/static';

                public function output($url)
                {
                    return $this->uri . $url;
                }

                public function input($url)
                {
                    return Str::shift($url, $this->uri);
                }
            };

            $manager = new StaticImageManager(new ImageManager(), __DIR__ . '/../public', __DIR__ . '/../public/static', $decorator);

            $this->ioc()->load(StaticImages::class, $manager);

            return $manager;
        });
    }
}
