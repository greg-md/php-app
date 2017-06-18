<?php

namespace App;

use Greg\Framework\Translation\Translator;
use Greg\StaticImage\StaticImageManager;
use Greg\View\ViewerContract;

class BladeDirectives
{
    private $viewer;

    private $translator;

    private $imageManager;

    public function __construct(ViewerContract $viewer, Translator $translator, StaticImageManager $imageManager)
    {
        $this->viewer = $viewer;

        $this->translator = $translator;

        $this->imageManager = $imageManager;
    }

    public function load()
    {
        $this->viewer->directive('t', function($key, ...$args) {
            return $this->translator->translate($key, ...$args);
        });

        $this->viewer->directive('tk', function($key, $text, ...$args) {
            return $this->translator->translateKey($key, $text, ...$args);
        });

        $this->viewer->directive('alert', function ($message) {
            return '<script>alert("' . addslashes($message) . '")</script>';
        });

        $this->viewer->directive('img', function($src, $format) {
            return $this->imageManager->url($src, $format);
        });
    }
}
