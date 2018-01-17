<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return 'Home';
    }

    public function show()
    {
        return view('home.show');
    }
}
