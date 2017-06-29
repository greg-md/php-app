<?php

namespace App;

use App\Console\ConsoleKernel;
use App\Http\HttpKernel;
use App\Resources\StaticImages;
use App\Resources\ViewDirectives;
use Greg\StaticImage\ImageDecoratorStrategy;
use Greg\StaticImage\StaticImageManager;
use Greg\Support\Str;
use Greg\View\ViewBladeCompiler;
use Greg\View\Viewer;
use Greg\View\ViewerContract;
use Intervention\Image\ImageManager;

class Application extends \Greg\Framework\Application
{
    protected function boot()
    {
        $this->ioc()->register($this);

        $this->ioc()->inject(HttpKernel::class, function () {
            return new HttpKernel($this);
        });

        $this->ioc()->inject(ConsoleKernel::class, function () {
            return new ConsoleKernel($this);
        });

        $this->bootViewer();

        $this->bootStaticImage();
    }

    private function bootViewer()
    {
        $this->ioc()->inject(ViewerContract::class, function () {
            $viewer = new Viewer(__DIR__ . '/../resources/views');

            $viewer->addExtension('.blade.php', function () {
                return new ViewBladeCompiler(__DIR__ . '/../storage/views');
            });

            $this->ioc()->load(ViewDirectives::class, $viewer);

            return $viewer;
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
