<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Society;
use App\Models\Vaccinations;
use App\Models\Consultation;

use Illuminate\Support\Facades\Validator;

class VaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($token)
    {
        $society = Society::where('login_tokens', $token)->first();
        if ($society) {
            $vaccination = Vaccinations::where('society_id', $society->id)->with('spot','vaccinator', 'vaccine')->get();
            $totalVaccine = count(Vaccinations::where('society_id', $society->id)->get());
            if ($totalVaccine === 1) {
                return response()->json([
                    'status' => "200",
                    'first' => $vaccination[0],
                'second' => null,
                    'totalVaccine' => $totalVaccine
                ]);
            }else if($totalVaccine === 2){
                return response()->json([
                    'status' => "200",
                    'first' => $vaccination[0],
                    'second' => $vaccination[1],
                    'totalVaccine' => $totalVaccine
                ]);
            }
            return response()->json([
                'status' => "200",
                'totalVaccine' => $totalVaccine
            ]);
            
        }else{
            return response()->json([
                'status' => "401",
                'message' => "Unauthorized user"
            ]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register($token,Request $request)
    {
        $society = Society::where('login_tokens', $token)->first();
        if ($society) {
            $totalVaccine = Vaccinations::where('society_id', $society->id)->get();
            $consul = Consultation::where('society_id', $society->id)->get();
                        
            if ($consul[0]->status === 'accepted' && count($totalVaccine) != 2) {
                $validate = Validator::make($request->all(), [
                    'date' => 'required|date',
                    'spot_id' => 'required'
                ]);
                if ($validate->fails()) {
                    return response()->json([
                        'status' => "401",
                        'errors' => $validate->errors()
                    ]);
                }
                $vaccination = new Vaccinations();
                $vaccination->society_id = $society->id;
                $vaccination->spot_id = $request->spot_id;
                $vaccination->date = $request->date;


                // Check date
                $vaccination_date = Vaccinations::where('society_id', $society->id)->first();
                
                if ($vaccination_date) {                    
                    $date = strtotime($vaccination_date->date);
                    $date_now = strtotime($request->date);
                    $selisih = $date_now - $date;
                    // time to days
                    $day = $selisih / (60 * 60 * 24);
                    //check if the date is more than 30 days

                    if ($day < 30) {
                        return response()->json([
                            'status' => "401",
                            'message' => "Vaccination date must be at least 30 days"
                        ]);
                    }else{
                        $vaccination->save();
                        return response()->json([
                            'status' => "200",
                            'message' => "Second vaccination registered successful",
                            'total' => count($totalVaccine)
                        ]);
                    }
                }else{
                     $vaccination->save();
                     return response()->json([
                        'status' => "200",
                        'message' => "First vaccination registered successful",
                        'total' => count($totalVaccine)
                    ]);
                }
            }else if(count($totalVaccine) === 2){
                return response()->json([
                    'status' => "401",
                    'message' => "Society has been 2x vaccinated"
                ]); 
            }else {
                return response()->json([
                    'status' => "401",
                    'message' => "Your consultation must be accepted by doctor before"
                ]); 
            }
        }else {
            return response()->json([
                'status' => "401",
                'message' => "Unauthorized user"
            ]); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
