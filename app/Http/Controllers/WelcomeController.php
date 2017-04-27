<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome.welcome');
    }

    public function feed()
    {
        return view('welcome.feed');
    }

    public function about()
    {
        return view('welcome.about');
    }
}
