<?php

namespace App\Http\Controllers;

use Greg\View\ViewerContract;

class HomeController
{
    public function index(ViewerContract $viewer)
    {
        return $viewer->render('home');
    }
}
