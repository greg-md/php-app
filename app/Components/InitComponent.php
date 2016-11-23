<?php

namespace App\Components;

use App\Contracts\SettingsContract;
use App\Images;
use App\Services\LanguagesService;
use App\Services\SettingsService;
use App\Services\TranslatesService;
use App\Settings;
use App\Strategies\LanguagesStrategy;
use App\Strategies\SettingsStrategy;
use App\Strategies\TranslatesStrategy;
use App\View\BladeDirectives;
use Greg\ApplicationContract;
use Greg\Cache\CacheManager;
use Greg\Orm\Driver\DriverInterface;
use Greg\Orm\Driver\Mysql;
use Greg\StaticImage\ImageCollector;
use Greg\Support\Arr;
use Greg\Translation\Translator;
use Greg\Translation\TranslatorContract;
use Greg\View\ViewBladeCompiler;
use Greg\View\Viewer;
use Greg\View\ViewerContract;
use Intervention\Image\ImageManager;

class InitComponent
{
    protected $app = null;

    public function __construct(ApplicationContract $app)
    {
        $this->app = $app;
    }

    public function initViewer()
    {
        $this->app->ioc()->inject(ViewerContract::class, function () {
            $class = new Viewer($this->app->basePath() . '/resources/views');

            $class->addExtension('.blade.php', function (ViewerContract $viewer) {
                $compiler = new ViewBladeCompiler($viewer, $this->app->basePath() . '/storage/views');

                $directives = new BladeDirectives($this->app, $compiler);

                $directives->load();

                return $compiler;
            });

            return $class;
        });
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

    public function initSettings()
    {
        $this->app->ioc()->inject(SettingsStrategy::class, SettingsService::class);

        $this->app->ioc()->inject(SettingsContract::class, function(SettingsStrategy $strategy) {
            return new Settings($strategy->getList());
        });
    }

    public function initTranslator()
    {
        $this->app->ioc()->inject(LanguagesStrategy::class, LanguagesService::class);

        $this->app->ioc()->inject(TranslatesStrategy::class, TranslatesService::class);

        $this->app->ioc()->inject(TranslatorContract::class, function (LanguagesStrategy $strategy) {
            $class = new Translator(require __DIR__ . '/../../resources/translates/general.php');

            $rows = $strategy->getAll();

            if ($rows->count()) {
                $languages = Arr::group($rows->toArray(), 'SystemName');

                $base = $rows->firstWhere('Base', true);

                if (!$base) {
                    $base = $rows->first();
                }

                $class
                    ->setLanguages($languages)
                    ->setCurrentLanguage($base['SystemName'])
                    ->setDefaultLanguage($base['SystemName']);

                $this->app->on(ApplicationContract::EVENT_FINISHED, function(TranslatesService $strategy) use ($class) {
                    if ($translates = $class->getNewTranslates()) {
                        $strategy->addTranslates($class->getCurrentLanguage(), $translates, $class->getLanguages());
                    }
                });
            }

            return $class;
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
