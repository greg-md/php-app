<?php

namespace App\Http\Controllers;

use App\Http\ControllerAbstract;

class HomeController extends ControllerAbstract
{
    public function index()
    {
        return $this->render('home');
    }
}
