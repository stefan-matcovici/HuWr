<?php

namespace App\Http\Controllers ;

use App\HumanMigration as Migration;
use App\User as User;
use Feed;
use Twitter;


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

    public function feedGet()
    {
        $feed = \App::make("feed");
        //dd(User::find(1));
        //dd($feed);

        // multiple feeds are supported
        // if you are using caching you should set different cache keys for your feeds

        // cache the feed for 60 minutes (second parameter is optional)
        //$feed->setCache(60);



        // check if there is cached feed and build new only if is not
        if (!$feed->isCached() or true)
        {
            // creating rss feed with our most recent 20 posts
            $posts = \DB::table('human_migrations')->get();
            dd($posts);
            // set your feed's title, description, link, pubdate and language
            $feed->title = 'HuWr';
            $feed->description = 'Migration Feed';
            $feed->logo = 'img/logo.png';
            $feed->link = route('feed.get');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            //$feed->pubdate = $posts[0]->created_at;
            $feed->lang = 'en';
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(100); // maximum length of description text



            foreach ($posts as $post)
            {

                // set item's title, author, url, pubdate, description, content, enclosure (optional)*
                //dd('Migrated from'.$post->departure_city.', '.$post->departure_country.' to '.$post->arrival_city.', '.$post->arrival_country.' with '.
                //$post->adults.' adults'.' and '.$post->children.' children because of '.$post->reason.'.');
               $feed->add('Migrated from '.$post->departure_city.', '.$post->departure_country.' to '.$post->arrival_city.', '.$post->arrival_country,
                $post->user_id,
                $post->user_id,
                'http://localhost/PW/public/feed',
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

    public function about()
    {
        return view('welcome.about');
    }
}
