<?php

namespace App\Resources;

use Greg\StaticImage\Imagix;
use Greg\View\Viewer;

class ViewDirectives
{
    private $viewer;

    private $imageManager;

    public function __construct(Viewer $viewer, Imagix $imageManager)
    {
        $this->viewer = $viewer;

        $this->imageManager = $imageManager;

        $this->boot();
    }

    private function boot()
    {
        $this->viewer->directive('img', function ($src, $format) {
            return $this->imageManager->url($src, $format);
        });
    }
}
