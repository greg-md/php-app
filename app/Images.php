<?php

namespace App;

use Greg\StaticImage\ImageCollector;
use Intervention\Image\Constraint;
use Intervention\Image\Image;

class Images
{
    protected $collector = null;

    public function __construct(ImageCollector $collector)
    {
        $this->collector = $collector;
    }

    public function load()
    {
        $this->collector->addFormat('favicon', function (Image $image) {
            $image->resize(128, 128, function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        });
    }
}
