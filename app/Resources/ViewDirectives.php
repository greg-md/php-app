<?php

namespace App\Resources;

use Greg\StaticImage\StaticImageManager;
use Greg\View\ViewerContract;

class ViewDirectives
{
    private $viewer;

    private $imageManager;

    public function __construct(ViewerContract $viewer, StaticImageManager $imageManager)
    {
        $this->viewer = $viewer;

        $this->imageManager = $imageManager;

        $this->boot();
    }

    private function boot()
    {
        $this->viewer->directive('img', function($src, $format) {
            return $this->imageManager->url($src, $format);
        });
    }
}
