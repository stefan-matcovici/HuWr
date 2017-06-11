<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HumanMigration as Migration;

/**
 * Class ApiController
 *
 * @package App\Http\Controllers
 *
 * @SWG\Swagger(
 *     basePath="/api",
 *     host="protected-chamber-47547.herokuapp.com",
 *     schemes={"https"},
 *     @SWG\Info(
 *         version="1.0",
 *         title="Sample API",
 *          description="A simple API to get important data about human migrations",
 *         @SWG\Contact(name="HuWr Team", url="protected-chamber-47547.herokuapp.com/about"),
 *     ),
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     )
 * )
 */
class APIController extends Controller
{
    public function index()
    {
        return view("swagger.index");
    }

    /**
     * Displays just the most recent migrations
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/recent",
     *     schemes={"https"},
     *     description="Returns the most recent migrations within the last month.",
     *     operationId="api.recent.index",
     *     produces={"application/json"},
     *     tags={"recent"},
     *     @SWG\Response(
     *         response=200,
     *         description="The most recent migrations."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found.",
     *     )
     * )
     */
    public function recentMigrations() {
        $migrations = DB::select("
        select * 
        from human_migrations 
        WHERE YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
        AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)");

        return $migrations;
    }

    /**
     * Displays the whole collection of migrations
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/all",
     *     schemes={"https"},
     *     description="Returns all migrations registred in application.",
     *     operationId="api.all.index",
     *     produces={"application/json"},
     *     tags={"all"},
     *     @SWG\Response(
     *         response=200,
     *         description="All migrations."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found.",
     *     )
     * )
     */
    public function allMigrations() {
        $migrations = DB::select("
        select * 
        from human_migrations");

        return $migrations;
    }

    /**
     * Displays the most important migrations
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/important",
     *     schemes={"https"},
     *     description="Returns the most important migrations meaning the most used routes for migration.",
     *     operationId="api.important.index",
     *     produces={"application/json"},
     *     tags={"important"},
     *     @SWG\Response(
     *         response=200,
     *         description="The most important migrations."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found.",
     *     )
     * )
     */
    public function importantMigrations() {
        $migrations = DB::select("
        select * 
        from human_migrations
        where adults + children > 100");

        return $migrations;
    }

    /**
     * Returns the migrations associated with one country
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/country-migrations/{country}",
     *     schemes={"https"},
     *     description="Returns the migrations from and to one particular country",
     *     operationId="api.country.index",
     *     produces={"application/json"},
     *     tags={"country"},
     *     @SWG\Parameter(
     *         name="country",
     *         in="path",
     *         description="country ISO-2 code you are interested in",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="The migrations for country."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found.",
     *     )
     * )
     */
    public function countryMigrations(Request $request, $countryInitials) {
        $migrations = Migration::where('departure_country', $countryInitials)
                ->orWhere('arrival_country', $countryInitials)
                ->get();

        return $migrations;
    }

    public function country()
    {
        $migrations = Migration::all();
        return view('welcome.welcome',['migrations' => $migrations]);
    }


    /**
     * Returns the atom feed with all migrations
     *
     *
     * @SWG\Get(
     *     path="/atom-feed",
     *     schemes={"https"},
     *     description="Returns the migrations from and to one particular country",
     *     operationId="api.feed",
     *     produces={"application/xml"},
     *     tags={"feed"},
     *     @SWG\Response(
     *         response=200,
     *         description="The migrations for country."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found.",
     *     )
     * )
     */
    public function feedGet()
    {
        $feed = \App::make("feed");
        $feed->setCache(60);
        if (!$feed->isCached())
        {
            $posts = \DB::table('human_migrations')->get();
            $feed->title = 'HuWr';
            $feed->description = 'Migration Feed';
            $feed->logo = 'img/logo.png';
            $feed->link = route('feed.get');
            $feed->setDateFormat('datetime');
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

        return $feed->render('atom');
    }
}
