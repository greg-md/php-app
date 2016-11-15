<?php

namespace App;

use Greg\ApplicationContract;
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

    public function __construct(ApplicationContract $app, ViewBladeCompiler $compiler)
    {
        $this->app = $app;

        $this->compiler = $compiler;

        $this->startup();
    }

    protected function startup()
    {
        $this->translator = $this->app->ioc()->expect(Translator::class);

        $this->imageCollector = $this->app->ioc()->expect(ImageCollector::class);
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
