<?php

namespace App\Resources;

use Greg\StaticImage\StaticImageManager;
use Intervention\Image\Constraint;
use Intervention\Image\Image;

class Images
{
    private $manager;

    public function __construct(StaticImageManager $manager)
    {
        $this->manager = $manager;

        $this->boot();
    }

    private function boot()
    {
        $this->manager->format('favicon', function (Image $image) {
            $image->resize(128, 128, function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        });
    }
}
