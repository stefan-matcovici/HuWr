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
        $migrationtype = $request->input('emigrationorimmigration');
        $arrival = app('geocoder')->geocode($request->input('country-location'))->all()[0];
        $arrivalCode = $arrival->getCountryCode();
        $predicted_migrations = [];
        if ($migrationtype == "immigration") {
            $migrations = DB::select(DB::raw("select * 
                    from human_migrations
                    where arrival_country=:arrivalCode order by created_at desc limit 5"),
                array('arrivalCode' => $arrivalCode,
                ));
//            $migrations = DB::select("
//                    select *
//                    from human_migrations
//                    where arrival_country=" . "'" . $arrivalCode . "' order by created_at desc limit 5");
            $predicted_migrations = collect($this->getFuturePredictions($migrations, $end, $start));
        } else {
            $migrations = DB::select(DB::raw("select * 
                    from human_migrations
                    where departure_country=:arrivalCode order by created_at desc limit 5"),
                array('arrivalCode' => $arrivalCode,
                ));
//            $migrations = DB::select("
//        select *
//        from human_migrations
//       where departure_country=" . "'" . $arrivalCode . "' order by created_at desc limit 5");
//            $predicted_migrations = collect($this->getFuturePredictions($migrations,$end,$start))  ;
//        }
            //dd($migrations);
            return $this->getFuturePredictions($migrations, $end, $start);
            //return view('app.prediction_result', ['migrations' => $predicted_migrations,"users" => collect(array()),"prediction" => true]);
        }
    }
    public function getFuturePredictions($migrations,$endDate,$startDate)
    {
        $futurePredictions = [];
        $contor=0;
        foreach($migrations as $migration)
        {
            if($migration->reason=="Personal" || $migration->reason=="Other"||$migration->reason=="Education") {
                $years = $this->getYears($endDate, $startDate)->y;
                $date = date_create($startDate);
                $date->modify('-1 year')->format('Y-m-d H:i:s');
                for ($i = 0; $i <= $years; $i++) {
                    $date->add(new DateInterval('P1Y'));
                    $futurePredictions[$contor]["created_at"] = $date->format('Y-m-d H:i:s');
                    $futurePredictions[$contor]["departure_country"] = $migration->departure_country;
                    $futurePredictions[$contor]["departure_city"] = $migration->departure_city;
                    $futurePredictions[$contor]["departure_longitude"] = $migration->departure_longitude;
                    $futurePredictions[$contor]["departure_latitude"] = $migration->departure_latitude;
                    $futurePredictions[$contor]["arrvial_country"] = $migration->arrival_country;
                    $futurePredictions[$contor]["arrival_city"] = $migration->arrival_city;
                    $futurePredictions[$contor]["arrival_longitude"] = $migration->arrival_longitude;
                    $futurePredictions[$contor]["arrival_latitude"] = $migration->arrival_latitude;
                    $futurePredictions[$contor]["children"] = $migration->children;
                    $futurePredictions[$contor]["adults"] = $migration->adults;
                    $futurePredictions[$contor]["reason"] = $migration->reason;
                    $contor=$contor+1;
                }

            }
            if($migration->reason=="War" || $migration->reason=="Religion"||$migration->reason=="Economics")
            {
                    $years = $this->getYears($endDate, $startDate)->y;
                    $date = date_create($startDate);
                    $date->modify('-1 year')->format('Y-m-d H:i:s');
                    for($j = 0; $j <=$years; $j++)
                    {
                        $date->add(new DateInterval('P1Y'));
                        $futurePredictions[$contor]["created_at"]=$date->format('Y-m-d H:i:s');
                        $futurePredictions[$contor]["departure_country"]=$migration->departure_country;
                        $futurePredictions[$contor]["departure_city"]=$migration->departure_city;
                        $futurePredictions[$contor]["departure_longitude"]=$migration->departure_longitude;
                        $futurePredictions[$contor]["departure_latitude"]=$migration->departure_latitude;
                        $futurePredictions[$contor]["arrvial_country"]=$migration->arrival_country;
                        $futurePredictions[$contor]["arrival_city"]=$migration->arrival_city;
                        $futurePredictions[$contor]["arrival_longitude"]=$migration->arrival_longitude;
                        $futurePredictions[$contor]["arrival_latitude"]=$migration->arrival_latitude;
                        $futurePredictions[$contor]["children"]=$migration->children;
                        $futurePredictions[$contor]["adults"]=$migration->adults;
                        $futurePredictions[$contor]["reason"]=$migration->reason;
                        $contor=$contor+1;

                    }
            }
        }
        dd($futurePredictions);
        return $futurePredictions;

    }

    public function getYears($end,$start)
    {
        $startDate=date_create($start);
        $endDate= date_create($end);
        $startYear =$startDate->format( 'Y-m-d H:i:s');
        $endYear=$endDate->format('Y-m-d H:i:s');
        $d_start= new DateTime($startYear);
        $d_end= new DateTime($endYear);
        $years= $d_end->diff($d_start);
        return $years;
    }

    public function predictionsMap() {

    }
}
