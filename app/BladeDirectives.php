<?php

namespace App;

use Greg\Framework\Translation\Translator;
use Greg\StaticImage\StaticImageManager;
use Greg\View\ViewBladeCompiler;

class BladeDirectives
{
    private $compiler;

    private $translator;

    private $imageManager;

    public function __construct(ViewBladeCompiler $compiler, Translator $translator, StaticImageManager $imageManager)
    {
        $this->compiler = $compiler;

        $this->translator = $translator;

        $this->imageManager = $imageManager;
    }

    public function load()
    {
        $this->compiler->addDirective('t', function($key, ...$args) {
            return $this->translator->translate($key, ...$args);
        });

        $this->compiler->addDirective('tk', function($key, $text, ...$args) {
            return $this->translator->translateKey($key, $text, ...$args);
        });

        $this->compiler->addDirective('alert', function ($message) {
            return '<script>alert("' . addslashes($message) . '")</script>';
        });

        $this->compiler->addDirective('img', function($src, $format) {
            return $this->imageManager->url($src, $format);
        });
    }
}
