<?php

namespace App;

use Greg\Application;
use Greg\StaticImage\ImageCollector;
use Greg\Translation\Translator;
use Greg\View\ViewBladeCompiler;

class BladeDirectives
{
    protected $app = null;

    protected $compiler = null;

    /**
     * @var Translator
     */
    protected $translator = null;

    /**
     * @var ImageCollector
     */
    protected $imageCollector = null;

    public function __construct(Application $app, ViewBladeCompiler $compiler)
    {
        $this->app = $app;

        $this->compiler = $compiler;

        $this->startup();
    }

    protected function startup()
    {
        $this->translator = $this->app->make(Translator::class);

        $this->imageCollector = $this->app->make(ImageCollector::class);
    }

    public function load()
    {
        $this->compiler->directive('t', [$this->translator, 'translate']);

        $this->compiler->directive('tk', [$this->translator, 'translateKey']);

        $this->compiler->directive('alert', function ($message) {
            return '<script>alert("' . addslashes($message) . '")</script>';
        });

        $this->compiler->directive('img', [$this->imageCollector, 'url']);
    }
}
