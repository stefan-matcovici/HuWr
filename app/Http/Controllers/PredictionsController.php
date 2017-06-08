<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\HumanMigration as Migration;
use Illuminate\Support\Facades\DB;
use Redirect;
use DateInterval;
use DateTime;
class PredictionsController extends Controller
{
    public function getPredictions(Request $request)
    {
        $start = $request->input('starting-time');
        $end = $request->input('ending-time');
        $age=$request->input('childoradult');
        $arrival = app('geocoder')->geocode($request->input('country-location'))->all()[0];
        $arrivalCode=$arrival->getCountryCode();

        $migrations = DB::select("
        select * 
        from human_migrations
        where (created_at>=".$start." and arrival_country="."'".$arrivalCode."')");
        //dd($migrations);
        return $this->getFuturePredictions($migrations,$end);
        //return Redirect::route("home");
    }
    public function getFuturePredictions($migrations,$endDate)
    {
        $futurePredictions = [];
        foreach($migrations as $migration)
        {
            if($migration->reason=="Personal" || $migration->reason=="Other"||$migration->reason=="Education")
            {
                $years=$this->getYears($endDate,$migrations)->y;
                $date = date_create( $migration->created_at);
                for($i = 0; $i <$years; $i++)
                {
                    $date->add(new DateInterval('P1Y'));
                    $futurePredictions[$i]["created_at"]=$date->format('Y-m-d H:i:s');
                    $futurePredictions[$i]["departure_country"]=$migration->departure_country;
                    $futurePredictions[$i]["departure_city"]=$migration->departure_city;
                    $futurePredictions[$i]["arrial_country"]=$migration->arrival_country;
                    $futurePredictions[$i]["arrial_city"]=$migration->arrival_city;
                    $futurePredictions[$i]["children"]=$migration->children;
                    $futurePredictions[$i]["adults"]=$migration->adults;
                }
            }
        }
        return $futurePredictions;

    }
    public function getYears($end,$migrations)
    {
        $endDate= date_create($end);
        $startYear = date( 'Y-m-d H:i:s');
        $endYear=$endDate->format('Y-m-d H:i:s');
        $d_start= new DateTime($startYear);
        $d_end= new DateTime($endYear);
        $years= $d_end->diff($d_start);
        return $years;
    }
}
