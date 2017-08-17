<?php

namespace App\Resources;

use Greg\Imagix\Imagix;
use Intervention\Image\Constraint;
use Intervention\Image\Image;

class ImagixFormats
{
    private $imagix;

    public function __construct(Imagix $imagix)
    {
        $this->imagix = $imagix;

        $this->boot();
    }

    private function boot()
    {
        $this->imagix->format('favicon', function (Image $image) {
            $image->resize(128, 128, function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        });
    }
}
