<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\HumanMigration as Migration;

class PredictionsController extends Controller
{
    public function getPredictions(Request $request)
    {
        $start = $request->input('starting-time');
        $end = $request->input('ending-time');
        $age=$request->input('childoradult');
        $location=$request->input('country-location');
        dd($start,$end,$age,$location);
    }
}
