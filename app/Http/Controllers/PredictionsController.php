<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\HumanMigration as Migration;
use Illuminate\Support\Facades\DB;

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
        where (>=".$start." and arrival_country="."'".$arrivalCode."')");
        return $migrations;
    }
}
