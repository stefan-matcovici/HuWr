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
        $child=$request->input('child');
        $adult=$request->input('adult');
        $location=$request->input('country-location');
        dd($start,$end,$child,$adult,$location);
    }
}
