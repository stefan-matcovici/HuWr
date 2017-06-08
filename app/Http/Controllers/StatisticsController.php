<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HumanMigration as Migration;
use DB;

class StatisticsController extends ApiController
{
    /**
     * Returns the migrations associated with one country by year
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/statistics/{country}/years",
     *     description="Returns the migrations by year",
     *     operationId="api.statistics.years",
     *     produces={"application/json"},
     *     tags={"statistics by year"},
     *     @SWG\Parameter(
     *         name="country",
     *         in="path",
     *         description="country ISO-2 code you are interested in",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="The migrations for country by year."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found.",
     *     )
     * )
     */
    public function countryIndexByYears(Request $request,$country)
    {
        $migrations = DB::select("SELECT YEAR(created_at) as year,COUNT(*) as migrations FROM human_migrations WHERE arrival_country = '$country' GROUP BY YEAR(created_at),arrival_country");

        return $migrations;
    }

    /**
     * Returns the migrations associated with one country according with reasons
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/statistics/{country}/reasons",
     *     description="Returns the migrations by reason",
     *     operationId="api.statistics.years",
     *     produces={"application/json"},
     *     tags={"statistics by reason"},
     *     @SWG\Parameter(
     *         name="country",
     *         in="path",
     *         description="country ISO-2 code you are interested in",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="The migrations for country by reason."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found.",
     *     )
     * )
     */
    public function countryIndexByReasons(Request $request,$country)
    {
        $migrations = DB::select("SELECT reason as label,COUNT(*) as count FROM human_migrations WHERE arrival_country = '$country' GROUP BY reason");
        return $migrations;
    }

    /**
     * Returns the number of children that migrated from specified country
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/statistics/{country}/children",
     *     description="Returns the children migrations",
     *     operationId="api.statistics.children",
     *     produces={"application/json"},
     *     tags={"children migrations statistics"},
     *     @SWG\Parameter(
     *         name="country",
     *         in="path",
     *         description="country ISO-2 code you are interested in",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="The children migrations for country."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found.",
     *     )
     * )
     */
    public function countryIndexByChildren(Request $request,$country)
    {
        $migrations = DB::select("SELECT DATE_FORMAT(created_at,\"%d-%b-%y\") as year,SUM(children) as close FROM human_migrations WHERE arrival_country = '$country' GROUP BY created_at");
        return $migrations;
    }
}
