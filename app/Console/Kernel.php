<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Twitter;
use App\HumanMigration as Migration;
use DateTime;
use Illuminate\Database\QueryException;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->call(function() {
             $tweets = $this->getHuwrTweets();
             if ($tweets == null) {
                 return;
             }
             $migrations = $this->parseTweets($tweets['statuses']);
//             dd($migrations);
             if ($migrations == null) {
                 return;
             }
             $this->storeMigrations($migrations);
         })->everyMinute();
    }

    private function parseTweets($tweets) {
        $parsedTweet = array();
        $counter = 0;
        foreach ($tweets as $tweet) {
            try {
                $parsedTweet[$counter]['created_at'] = $tweet['created_at'];
                $explodedString = explode(" ", $tweet['text']);
                $parsedTweet[$counter]['departure_city'] = substr($explodedString[2], 0, strlen($explodedString[2]) - 1);
                $parsedTweet[$counter]['departure_country'] = $explodedString[3];

                $parsedTweet[$counter]['arrival_city'] = substr($explodedString[5], 0, strlen($explodedString[5]) - 1);
                $parsedTweet[$counter]['arrival_country'] = $explodedString[6];

                $parsedTweet[$counter]['adults'] = $explodedString[8];
                $parsedTweet[$counter]['children'] = $explodedString[12];

                $parsedTweet[$counter]['reason'] = $explodedString[16];
                $parsedTweet[$counter]['user_id'] = $tweet['user']['id'];

                $counter++;
            } catch (\Exception $exception) {
                continue;
            }

        }

        return $parsedTweet;
    }

    private function getHuwrTweets() {
        try {
            return Twitter::getSearch(array('q' => '%23huwr', 'count' => 100, 'format' => 'array'));
        } catch (\Exception $exception) {
            return null;
        }

    }

    private function storeMigrations($migrations) {
        foreach ($migrations as $migration) {
            $migrationObj = new Migration();
            try {
                $departure = app('geocoder')->geocode($migration['departure_city'].', '.$migration['departure_country'])->all()[0];
                $arrival = app('geocoder')->geocode($migration['arrival_city'].', '.$migration['arrival_country'])->all()[0];
            } catch (\Exception $exception) {
                continue;
            }
            $migrationObj->departure_country = $departure->getCountryCode();
            $migrationObj->departure_city = $departure->getLocality();
            $migrationObj->departure_longitude = $departure->getCoordinates()->getLongitude();
            $migrationObj->departure_latitude = $departure->getCoordinates()->getLatitude();

            $migrationObj->arrival_country = $arrival->getCountryCode();
            $migrationObj->arrival_city = $arrival->getLocality();
            $migrationObj->arrival_longitude = $arrival->getCoordinates()->getLongitude();
            $migrationObj->arrival_latitude = $arrival->getCoordinates()->getLatitude();

            $migrationObj->adults = $migration['adults'];
            $migrationObj->children = $migration['children'];

            $migrationObj->reason = $migration['reason'];

            $migrationObj->user_id = 1;
            $migrationObj->setCreatedAt(new DateTime($migration['created_at']));
            try {
                $migrationObj->save();
            } catch (QueryException $queryException) {
                continue;
            }
        }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
