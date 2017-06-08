<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\HumanMigration as Migration;
use Illuminate\Support\Facades\DB;
use Redirect;
use DateInterval;

class PredictionsController extends Controller
{
    public function getPredictions(Request $request)
    {
        $start = $request->input('starting-time');
        $end = $request->input('ending-time');
        $age=$request->input('childoradult');
        $arrival = app('geocoder')->geocode($request->input('country-location'))->all()[0];
        $arrivalCode=$arrival->getCountryCode();
        //dd($start,$end,$age,$location);

        $migrations = DB::select("
        select * 
        from human_migrations
        where created_at>=".$start);

        /*$migrations = DB::select("
        select * 
        from human_migrations
        where (created_at>=".$start." and arrival_country="."'".$arrivalCode."')");*/
        $date = date_create( $migrations[0]->created_at);
        $date->add(new DateInterval('P1Y'));

        dd( $date->format('Y-m-d H:i:s'));
        return $migrations;
        //return Redirect::route("home");
    }
    public function getFuturePredictions($migrations)
    {
        $futurePredictions = [];
        foreach($migrations as $migration)
        {
            if($migration->reason=="Personal" || $migration->reason=="Other")
            {
                $futurePredictions["created_at"]=$migration->created_at;
                $futurePredictions["departure_country"]=$migration->departure_country;
                $futurePredictions["departure_city"]=$migration->departure_city;
            }
        }

    }
}
