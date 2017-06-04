<?php

namespace App\Http\Controllers ;

use App\HumanMigration as Migration;
use Request;

use App\User as User;
use Feed;
use Twitter;
use DateTime;


class WelcomeController extends Controller
{
    public function index()
    {
        $migrations = Migration::all()->where('id', '<', '30');
//        dd($migrations);
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

    public function feedGetId(Request $request,$id)
    {
        $migration = Migration::where('id',$id)->get()->first();
        return view('welcome.singleFeed',['migration' => $migration]);
    }

    public function about()
    {
        return view('welcome.about');
    }
}
