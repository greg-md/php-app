<?php

namespace App\Resources;

use Greg\Imagix\Imagix;
use Greg\View\Viewer;

class ViewDirectives
{
    private $viewer;

    private $imagix;

    public function __construct(Viewer $viewer, Imagix $imagix)
    {
        $this->viewer = $viewer;

        $this->imagix = $imagix;

        $this->boot();
    }

    private function boot()
    {
        $this->viewer->directive('img', function ($src, $format) {
            return $this->imagix->url($src, $format);
        });
    }
}
