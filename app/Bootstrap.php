<?php

namespace App;

use App\Viewer\Directives;
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
        $this->app()->ioc()->inject(ViewerContract::class, function () {
            $viewer = new Viewer($this->app()['base_path'] . '/resources/views');

            $viewer->addExtension('.blade.php', function () {
                return new ViewBladeCompiler($this->app()['base_path'] . '/storage/views');
            });

            $this->app()->ioc()->load(Directives::class, $viewer);

            return $viewer;
        });
    }

    public function bootCache()
    {
        $this->app()->ioc()->inject('redis', function() {
            $redis = new \Redis();

            $redis->connect($this->app()['redis.host'], $this->app()['redis.port']);

            return $redis;
        });

        $this->app()->ioc()->inject(CacheManager::class, function () {
            $manager = new CacheManager();

            $manager->register('base', function () {
                return new RedisCache($this->app()->ioc()->get('redis'));
            });

            $manager->setDefaultStoreName('base');

            return $manager;
        });
    }

    public function bootDb()
    {
        $this->app()->ioc()->inject('mysql', function () {
            $database = $this->app()['mysql.database'];
            $host = $this->app()['mysql.host'];
            $port = $this->app()['mysql.port'];
            $username = $this->app()['mysql.username'];
            $password = $this->app()['mysql.password'];

            return new MysqlDriver(
                new Pdo(
                    'mysql:dbname=' . $database . ';host=' . $host . ';port=' . $port,
                    $username,
                    $password
                )
            );
        });

        $this->app()->ioc()->inject(DriverManager::class, function () {
            $manager = new DriverManager();

            $manager->register('base', function() {
                return $this->app()->ioc()->get('mysql');
            });

            $manager->setDefaultDriverName('base');

            return $manager;
        });
    }

    public function bootTranslator()
    {
        $this->app()->ioc()->inject(Translator::class, Translator::class);
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

            $manager = new StaticImageManager(new ImageManager(), $publicPath, $publicPath . '/static', $decorator);

            $this->app()->ioc()->load(Images::class, $manager);

            return $manager;
        });
    }
}
