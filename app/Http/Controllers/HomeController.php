<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HumanMigration as Migration;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $migrations = Migration::all()->where('id', '<', '100');
        return view('app.home',['migrations' => $migrations]);
    }

    public function add()
    {
        return view('app.add');
    }

    public function statistics()
    {
        return view('app.statistics');
    }

    public function predictions()
    {
        return view('app.predictions');
    }

    public function profile()
    {
        return view('app.profile');
    }
}
