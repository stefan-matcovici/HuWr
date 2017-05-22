<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HumanMigration as Migration;

class WelcomeController extends Controller
{
    public function index()
    {
        $migrations = Migration::all();
        return view('welcome.welcome',['migrations' => $migrations]);
    }

    public function country()
    {
//        $result = app('geocoder')->reverse(43.882587,-103.454067)->get();
//        dd($result);
        $migrations = Migration::all();
        return view('welcome.welcome',['migrations' => $migrations]);
    }

    public function feed()
    {
        $migrations = Migration::paginate(15);
        return view('welcome.feed',['migrations' => $migrations]);
    }

    public function about()
    {
        return view('welcome.about');
    }
}
