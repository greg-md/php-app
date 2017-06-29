<?php

namespace App;

use App\Console\ConsoleKernel;
use App\Http\HttpKernel;
use App\Resources\StaticImages;
use App\Resources\ViewDirectives;
use Greg\AppCache\CacheServiceProvider;
use Greg\AppDebugBar\DebugBarServiceProvider;
use Greg\AppInstaller\AppServiceProvider;
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

        $this->addServiceProvider(new AppServiceProvider());
        $this->addServiceProvider(new DebugBarServiceProvider());
        $this->addServiceProvider(new CacheServiceProvider());

        $this->bootViewer();

        $this->bootDb();

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

    private function bootDb()
    {
        $this->ioc()->inject(DriverManager::class, function () {
            $manager = new DriverManager();

            $config = $this['db'];

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
