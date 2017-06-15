<?php

namespace App;

use App\Contracts\SettingsContract;
use App\Services\LanguagesService;
use App\Services\SettingsService;
use App\Services\TranslatesService;
use App\Strategies\LanguagesStrategy;
use App\Strategies\SettingsStrategy;
use App\Strategies\TranslatesStrategy;
use App\View\BladeDirectives;
use Greg\Cache\CacheManager;
use Greg\Framework\Application;
use Greg\Support\Arr;
use Greg\Support\Server;
use Greg\Support\Session;
use Greg\View\ViewBladeCompiler;
use Greg\View\Viewer;
use Greg\View\ViewerContract;
use Intervention\Image\ImageManager;

class Bootstrap extends \Greg\Framework\Bootstrap
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bootServerConfiguration()
    {
        Server::iniSet('error_reporting', env('server.ini.error_reporting', -1));
        Server::iniSet('display_errors', env('server.ini.display_errors', 1));
        Server::iniSet('display_startup_errors', env('server.ini.display_startup_errors', 1));

        Server::encoding('UTF-8');

        Server::timezone('UTC');
    }

    public function bootSessionConfiguration()
    {
        Session::persistent(true);
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
        $this->app->ioc()->addPrefixes('App\\Models\\');

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
