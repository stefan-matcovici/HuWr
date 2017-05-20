<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HumanMigration as Migration;

class WelcomeController extends Controller
{
    public function index()
    {
        $migrations = Migration::all();
        return view('welcome.welcome',['migrations' => $migrations->nth(100)]);
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
