<?php

namespace App\Http\Controllers ;

use Illuminate\Http\Request;
use App\HumanMigration as Migration;
use Feed;
use Twitter;


class WelcomeController extends Controller
{
    public function index()
    {
        $tweets = $this->getHuwrTweets();
        $migrations = $this->parseTweets($tweets['statuses']);
//        dd($migrations);
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

        // multiple feeds are supported
        // if you are using caching you should set different cache keys for your feeds

        // cache the feed for 60 minutes (second parameter is optional)
        $feed->setCache(60);

        // check if there is cached feed and build new only if is not
        if (!$feed->isCached())
        {
            // creating rss feed with our most recent 20 posts
            $posts = \DB::table('human_migrations')->get();

            // set your feed's title, description, link, pubdate and language
            $feed->title = 'HuWr';
            $feed->description = 'Migration Feed';
            $feed->logo = 'img/logo.png';
            $feed->link = url('feed.get');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            //$feed->pubdate = $posts[0]->created_at;
            $feed->lang = 'en';
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(100); // maximum length of description text

            foreach ($posts as $post)
            {
                // set item's title, author, url, pubdate, description, content, enclosure (optional)*
                $feed->add($post->departure_country, $post->departure_city, $post->arrival_country, $post->arrival_city, $post->departure_latitude,
                    $post->departure_longitude,$post->arrival_latitude,$post->arrival_longitude,$post->adults,$post->children,$post->reason,$post->user_id);
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

    private function parseTweets($tweets) {
        $parsedTweet = array();
        $counter = 0;
        foreach ($tweets as $tweet) {
            $parsedTweet[$counter]['created_at'] = $tweet['created_at'];
            $explodedString = explode(" ", $tweet['text']);

            $parsedTweet[$counter]['departure_city'] = substr($explodedString[2], 0, strlen($explodedString[2]) - 1);
            $parsedTweet[$counter]['departure_country'] = $explodedString[3];

            $parsedTweet[$counter]['arrival_city'] = substr($explodedString[5], 0, strlen($explodedString[5]) - 1);
            $parsedTweet[$counter]['arrival_country'] = $explodedString[6];

            $parsedTweet[$counter]['adults'] = $explodedString[8];
            $parsedTweet[$counter]['children'] = $explodedString[12];

            $parsedTweet[$counter]['reason'] = $explodedString[16];

            $counter++;
        }

        return $parsedTweet;
    }

    private function getHuwrTweets() {
        return Twitter::getSearch(array('q' => '%23huwr', 'count' => 100, 'format' => 'array'));
    }
}
