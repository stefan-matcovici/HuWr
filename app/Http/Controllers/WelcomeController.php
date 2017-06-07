<?php

namespace App\Http\Controllers ;

use App\HumanMigration as Migration;
use Request;

use App\User as User;
use Feed;
use Twitter;
use DB;


class WelcomeController extends Controller
{
    public function index()
    {
        $migrations = Migration::take(30)->get();
        $users = User::all();
//        dd($users);
//        dd($migrations);
        return view('welcome.welcome',['migrations' => $migrations, 'users' => $users]);
    }

    public function feed()
    {
        $migrations = Migration::paginate(15);
        return view('welcome.feed',['migrations' => $migrations]);
    }

    public function feedGetId(Request $request, $id)
    {
        $migration = Migration::where('id',$id)->get()->first();
        return view('welcome.singleFeed',['migration' => $migration]);
    }

    public function about()
    {
        return view('welcome.about');
    }
}
