<?php

namespace App;

use App\Models\LanguagesModel;
use App\Services\LanguagesService;
use App\Services\SettingsService;
use App\Services\TranslatesService;
use App\Strategies\LanguagesStrategy;
use App\Strategies\SettingsStrategy;
use App\Strategies\TranslatesStrategy;
use Greg\Cache\CacheManager;
use Greg\Cache\RedisCache;
use Greg\Framework\BootstrapAbstract;
use Greg\Framework\Translation\Translator;
use Greg\Orm\Driver\DriverManager;
use Greg\Orm\Driver\MysqlDriver;
use Greg\Orm\Driver\Pdo;
use Greg\StaticImage\ImageDecoratorStrategy;
use Greg\StaticImage\StaticImageManager;
use Greg\Support\Str;
use Greg\View\ViewBladeCompiler;
use Greg\View\Viewer;
use Greg\View\ViewerContract;
use Intervention\Image\ImageManager;

class Bootstrap extends BootstrapAbstract
{
    public function bootViewer()
    {
        $this->app()->ioc()->inject(ViewerContract::class, function (Translator $translator, StaticImageManager $imageManager) {
            $class = new Viewer($this->app()['base_path'] . '/resources/views');

            $class->addExtension('.blade.php', function (ViewerContract $viewer) use ($translator, $imageManager) {
                $compiler = new ViewBladeCompiler($viewer, $this->app()['base_path'] . '/storage/views');

                $directives = new BladeDirectives($compiler, $translator, $imageManager);

                $directives->load();

                return $compiler;
            });

            return $class;
        });
    }

    public function bootCache()
    {
        $this->app()->ioc()->inject(CacheManager::class, function () {
            $manager = new CacheManager();

            $manager->register('base', function () {
                return new RedisCache(new \Redis());
            });

            $manager->setDefaultStoreName('base');

            return $manager;
        });
    }

    public function bootDb()
    {
        $this->app()->ioc()->addPrefixes('App\\Models\\');

        $this->app()->ioc()->inject(DriverManager::class, function () {
            $manager = new DriverManager();

            $manager->register('base', function() {
                return new MysqlDriver(new Pdo(''));
            });

            $manager->setDefaultDriverName('base');
        });
    }

    public function bootSettings()
    {
        $this->app()->ioc()->inject(SettingsStrategy::class, SettingsService::class);

        $this->app()->ioc()->inject(Settings::class, function(SettingsStrategy $strategy) {
            return new Settings($strategy->getList());
        });
    }

    public function bootTranslator()
    {
        $this->app()->ioc()->inject(LanguagesStrategy::class, LanguagesService::class);

        $this->app()->ioc()->inject(TranslatesStrategy::class, TranslatesService::class);

        $this->app()->ioc()->inject(Translator::class, function (LanguagesStrategy $strategy) {
            $class = new Translator();

            $rows = $strategy->getAll();

            /** @var LanguagesModel $row */
            foreach ($rows as $row) {
                $class->addLanguage($row['Locale'], $row->record());
            }

            if ($row = $rows->searchWhere('Base', true) ?: $rows->row()) {
                $class->setDefaultLanguage($row['Locale']);
            }

            $this->app()->listen(Application::EVENT_FINISHED, function(TranslatesService $strategy) use ($class) {
                if ($translates = $class->newTranslates()) {
                    foreach ($translates as $language => $items) {
                        $strategy->addTranslates($language, $items, $class->getLanguages());
                    }
                }
            });

            return $class;
        });
    }

    public function bootStaticImage()
    {
        $this->app()->ioc()->inject(StaticImageManager::class, function () {
            $publicPath = $this->app()['public_path'];

            $decorator = new class implements ImageDecoratorStrategy
            {
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

            $collector = new StaticImageManager(new ImageManager(), $publicPath, $publicPath . '/static', $decorator);

            $images = new Images($collector);

            $images->load();

            return $collector;
        });
    }
}
