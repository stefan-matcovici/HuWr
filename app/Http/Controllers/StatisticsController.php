<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HumanMigration as Migration;
use DB;

class StatisticsController extends Controller
{
    public function countryIndexByYears(Request $request,$country)
    {
        $migrations = DB::select("SELECT YEAR(created_at) as year,COUNT(*) as migrations FROM human_migrations WHERE arrival_country = '$country' GROUP BY YEAR(created_at),arrival_country");

        return $migrations;
    }
}
