<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HumanMigration as Migration;
use App\User as User;
use Auth;


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
        $migrations = Migration::take(30)->get();
        $users = User::all();
        return view('app.home',['migrations' => $migrations, 'users' => $users]);
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
        $migrations = Migration::where('user_id',Auth::id())->take(5)->get();
        return view('app.profile',['migrations' => $migrations]);
    }
}
