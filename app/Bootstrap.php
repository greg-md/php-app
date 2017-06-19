<?php

namespace App;

use App\Resources\StaticImages;
use App\Resources\ViewDirectives;
use Greg\Cache\CacheManager;
use Greg\Cache\RedisCache;
use Greg\Framework\BootstrapAbstract;
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
            $viewer = new Viewer(__DIR__ . '/../resources/views');

            $viewer->addExtension('.blade.php', function () {
                return new ViewBladeCompiler(__DIR__ . '/../storage/views');
            });

            $this->app()->ioc()->load(ViewDirectives::class, $viewer);

            return $viewer;
        });
    }

    public function bootCache()
    {
        $this->app()->ioc()->inject(CacheManager::class, function () {
            $manager = new CacheManager();

            $config = $this->app()['cache'];

            foreach ((array) ($config['stores'] ?? []) as $name => $credentials) {
                $manager->register($name, function () use ($name, $credentials) {
                    $type = $credentials['type'] ?? null;

                    if ($type == 'redis') {
                        $redis = new \Redis();

                        $redis->connect($credentials['host'] ?? '127.0.0.1', $credentials['port'] ?? 6379);

                        return new RedisCache($redis);
                    }

                    throw new \Exception('Unsupported cache type `' . $type . '` for `' . $name . '`.');
                });
            }

            if ($defaultStore = $config['default_store'] ?? null) {
                $manager->setDefaultStoreName($defaultStore);
            }

            return $manager;
        });
    }

    public function bootDb()
    {
        $this->app()->ioc()->inject(DriverManager::class, function () {
            $manager = new DriverManager();

            $config = $this->app()['db'];

            foreach ((array) ($config['drivers'] ?? []) as $name => $credentials) {
                $manager->register($name, function () use ($credentials) {
                    return new MysqlDriver(
                        new Pdo(
                            'mysql:dbname=' . ($credentials['database'] ?? 'app')
                                . ';host=' . ($credentials['host'] ?? '127.0.0.1')
                                . ';port=' . ($credentials['port'] ?? 3306),
                            $credentials['username'] ?? 'root',
                            $credentials['password'] ?? ''
                        )
                    );
                });
            }

            if ($defaultDriver = $config['default_driver'] ?? null) {
                $manager->setDefaultDriverName($defaultDriver);
            }

            return $manager;
        });
    }

    public function bootStaticImage()
    {
        $this->app()->ioc()->inject(StaticImageManager::class, function () {
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

            $this->app()->ioc()->load(StaticImages::class, $manager);

            return $manager;
        });
    }
}
