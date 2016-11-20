<?php

namespace App\View;

use Greg\ApplicationContract;
use Greg\StaticImage\ImageCollector;
use Greg\Translation\TranslatorContract;
use Greg\View\ViewBladeCompiler;

class BladeDirectives
{
    protected $app = null;

    protected $compiler = null;

    public function __construct(ApplicationContract $app, ViewBladeCompiler $compiler)
    {
        $this->app = $app;

        $this->compiler = $compiler;
    }

    /**
     * @return TranslatorContract
     * @throws \Exception
     */
    protected function translator()
    {
        return $this->app->ioc()->expect(TranslatorContract::class);
    }

    /**
     * @return ImageCollector
     * @throws \Exception
     */
    protected function imageCollector()
    {
        return $this->app->ioc()->expect(ImageCollector::class);
    }

    public function load()
    {
        $this->compiler->directive('t', function($key, ...$args) {
            return $this->translator()->translate($key, ...$args);
        });

        $this->compiler->directive('tk', function($key, $text, ...$args) {
            return $this->translator()->translateKey($key, $text, ...$args);
        });

        $this->compiler->directive('alert', function ($message) {
            return '<script>alert("' . addslashes($message) . '")</script>';
        });

        $this->compiler->directive('img', function($src, $format) {
            return $this->imageCollector()->url($src, $format);
        });
    }
}
