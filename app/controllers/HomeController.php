<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // $this->view("home/index");
        $this->render('home/index', ['title' => 'Home', 'bodyClass' => 'has-hero']);

    }
}