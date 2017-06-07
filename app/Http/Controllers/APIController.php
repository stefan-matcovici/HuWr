<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HumanMigration as Migration;

class APIController extends Controller
{
    public function recentMigrations() {
        $migrations = DB::select("
        select * 
        from human_migrations 
        WHERE YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
        AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)");

        return $migrations;
    }

    public function allMigrations() {
        $migrations = DB::select("
        select * 
        from human_migrations");

        return $migrations;
    }

    public function importantMigrations() {
        $migrations = DB::select("
        select * 
        from human_migrations
        where adults + children > 100");

        return $migrations;
    }

    public function countryMigrations(Request $request, $countryInitials) {
        $migrations = Migration::where('departure_country', $countryInitials)->orWhere('arrival_country', $countryInitials)->get();

        return $migrations;
    }


    public function country()
    {
        $migrations = Migration::all();
        return view('welcome.welcome',['migrations' => $migrations]);
    }

    public function feedGet()
    {
        $feed = \App::make("feed");
        //$feed->setCache(60);
        if (!$feed->isCached() or true)
        {
            $posts = \DB::table('human_migrations')->get();
            $feed->title = 'HuWr';
            $feed->description = 'Migration Feed';
            $feed->logo = 'img/logo.png';
            $feed->link = route('feed.get');
            $feed->setDateFormat('datetime');
            //$feed->pubdate = $posts[0]->created_at;
            $feed->lang = 'en';
            $feed->setShortening(true);
            $feed->setTextLimit(100);



            foreach ($posts as $post)
            {
                $feed->add('Migrated from '.$post->departure_city.', '.$post->departure_country.' to '.$post->arrival_city.', '.$post->arrival_country,
                    'SAA',
                    'http://localhost/PW/public/feed/'.$post->id,
                    $post->created_at,
                    'Migration Feed',
                    'Migrated from '.$post->departure_city.', '.$post->departure_country.' to '.$post->arrival_city.', '.$post->arrival_country.' with '.
                    $post->adults.' adults'.' and '.$post->children.' children because of '.$post->reason.'.');
            }

        }

        // first param is the feed format
        // optional: second param is cache duration (value of 0 turns off caching)
        // optional: you can set custom cache key with 3rd param as string
        return $feed->render('atom');

        // to return your feed as a string set second param to -1
        // $xml = $feed->render('atom', -1);
    }
}
