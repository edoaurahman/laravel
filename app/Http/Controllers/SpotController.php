<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spots;
use App\Models\Society;
use App\Models\Vaccinations;

class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function spots($token)
    {
        $society = Society::where('login_tokens', $token)->first();
        if ($society) {
            $spots = Spots::where('regional_id', $society->regional_id)->with('available_vaccines')->get();
            return response()->json([
                'status' => "200",
                'spots' => $spots
            ]);
        }else {
            return response()->json([
                'status' => "401",
                'message' => "Unauthorized user"
            ]); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getById($token, $date, $id)
    {
        $society = Society::where('login_tokens', $token)->first();
        if ($society) {
            $spots = Vaccinations::where('spot_id', $id)->where('date', $date)->first();
            if ($spots) {
                $vaccine_count = Vaccinations::where('spot_id', $id)->where('date', $date)->get();

                $spot = Spots::where('id', $spots->spot_id)->get();
                return response()->json([
                    'status' => "200",
                    'date' => $date,
                    'spot' => $spot,
                    'vaccinations_count' => count($vaccine_count)
                ]); 
            }else{
                return response()->json([
                    'status' => "200",
                    'date' => $date,
                    'spot' => null,
                    'vaccinations_count' => 0
                ]);
            }
        }else {
            return response()->json([
                'status' => "401",
                'message' => "Unauthorized user"
            ]); 
        }
    }
}
