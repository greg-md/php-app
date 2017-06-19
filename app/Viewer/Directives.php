<?php

namespace App\Viewer;

use Greg\Framework\Translation\Translator;
use Greg\StaticImage\StaticImageManager;
use Greg\View\ViewerContract;

class Directives
{
    private $viewer;

    private $translator;

    private $imageManager;

    public function __construct(ViewerContract $viewer, Translator $translator, StaticImageManager $imageManager)
    {
        $this->viewer = $viewer;

        $this->translator = $translator;

        $this->imageManager = $imageManager;

        $this->boot();
    }

    private function boot()
    {
        $this->viewer->directive('t', function($key, ...$args) {
            return $this->translator->translate($key, ...$args);
        });

        $this->viewer->directive('tk', function($key, $text, ...$args) {
            return $this->translator->translateKey($key, $text, ...$args);
        });

        $this->viewer->directive('img', function($src, $format) {
            return $this->imageManager->url($src, $format);
        });
    }
}
