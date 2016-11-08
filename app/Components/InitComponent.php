<?php

namespace App\Components;

use App\BladeDirectives;
use App\Images;
use App\Services\OptionsService;
use App\Services\TranslatorService;
use App\Strategies\OptionsStrategy;
use App\Strategies\TranslatorStrategy;
use Greg\ApplicationStrategy;
use Greg\Cache\CacheManager;
use Greg\Orm\Driver\DriverInterface;
use Greg\Orm\Driver\Mysql;
use Greg\StaticImage\ImageCollector;
use Greg\View\ViewBladeCompiler;
use Greg\View\Viewer;
use Intervention\Image\ImageManager;

class InitComponent
{
    protected $app = null;

    public function __construct(ApplicationStrategy $app)
    {
        $this->app = $app;
    }

    public function initViewer()
    {
        $this->app->ioc()->inject(Viewer::class, function () {
            $class = new Viewer($this->app->basePath() . '/resources/views');

            $class->addExtension('.blade.php', function (Viewer $viewer) {
                $compiler = new ViewBladeCompiler($viewer, $this->app->basePath() . '/storage/views');

                $directives = new BladeDirectives($this->app, $compiler);

                $directives->load();

                return $compiler;
            });

            return $class;
        });
    }

    public function initStrategies()
    {
        $this->app->ioc()->inject(OptionsStrategy::class, OptionsService::class);

        $this->app->ioc()->inject(TranslatorStrategy::class, TranslatorService::class);
    }

    public function initCache()
    {
        $this->app->ioc()->inject(CacheManager::class, function () {
            $manager = new CacheManager();

            foreach ($this->app->config()->getIndexArray('cache.containers') as $name => $container) {
                $manager->register($name, function () use ($container) {
                    return $this->app->ioc()->load(...(array) $container);
                });
            }

            if ($defaultContainer = $this->app['cache.default_container']) {
                $manager->setDefaultContainerName($defaultContainer);
            }

            return $manager;
        });
    }

    public function initDb()
    {
        $this->app->ioc()->inject(DriverInterface::class, function () {
            return new Mysql(
                $this->app['db.dsn'],
                $this->app['db.username'],
                $this->app['db.password'],
                $this->app['db.options']
            );
        });
    }

    public function initImageCollector()
    {
        $this->app->ioc()->inject(ImageCollector::class, function () {
            $publicPath = $this->app->publicPath();

            $collector = new ImageCollector(new ImageManager(), $publicPath, $publicPath . '/static', '/static');

            $images = new Images($collector);

            $images->load();

            return $collector;
        });
    }
}
