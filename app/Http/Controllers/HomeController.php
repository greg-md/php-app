<?php

namespace App\Http\Controllers;

use Greg\View\ViewerContract;

class HomeController
{
    private $viewer;

    public function __construct(ViewerContract $viewer)
    {
        $this->viewer = $viewer;
    }

    public function index()
    {
        return $this->viewer->render('home');
    }
}
