<?php

namespace App\Http\Controllers;

use Greg\View\Viewer;

class HomeController
{
    public function index(Viewer $viewer)
    {
        return $viewer->render('home');
    }
}
