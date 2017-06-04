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

    public function countryIndexByReasons(Request $request,$country)
    {
        $migrations = DB::select("SELECT reason as label,COUNT(*) as count FROM human_migrations WHERE arrival_country = '$country' GROUP BY reason");
        return $migrations;
    }

    public function countryIndexByChildren(Request $request,$country)
    {
        $migrations = DB::select("SELECT YEAR(created_at) as year,SUM(children) as close FROM human_migrations WHERE arrival_country = '$country' GROUP BY YEAR(created_at)");
        return $migrations;
    }
}
